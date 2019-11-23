<?php

namespace JK\CmsBundle\Tests\Controller\Article;

use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Controller\Article\CreateArticleAction;
use Doctrine\Common\Collections\ArrayCollection;
use LAG\AdminBundle\Admin\AdminInterface;
use LAG\AdminBundle\Configuration\AdminConfiguration;
use LAG\AdminBundle\DataProvider\DataProviderInterface;
use LAG\AdminBundle\Factory\AdminFactory;
use LAG\AdminBundle\Factory\DataProviderFactory;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CreateArticleActionTest extends TestCase
{
    /**
     * @dataProvider actionProvider
     *
     * @param string $actionName
     */
    public function testInvoke(string $actionName)
    {
        list($controller, $adminFactory, $dataProviderFactory, $translator, $router) = $this->createController();

        $request = new Request();
        $entity = new Article();
        $entities = new ArrayCollection();

        $provider = $this->createMock(DataProviderInterface::class);
        $provider
            ->expects($this->once())
            ->method('create')
            ->willReturn($entity)
        ;

        $adminConfiguration = $this->createMock(AdminConfiguration::class);
        $adminConfiguration
            ->expects($this->atLeast(3))
            ->method('get')
            ->willReturnMap([
                ['data_provider', 'my_little_provider'],
                ['actions', [$actionName => []]],
                ['routing_name_pattern', 'my_routing_pattern.{admin}.{action}'],
            ])
        ;

        $admin = $this->createMock(AdminInterface::class);
        $admin
            ->expects($this->atLeast(3))
            ->method('getConfiguration')
            ->willReturn($adminConfiguration)
        ;
        $admin
            ->expects($this->once())
            ->method('getEntities')
            ->willReturn($entities)
        ;
        $admin
            ->expects($this->once())
            ->method('getName')
            ->willReturn('my_admin')
        ;

        $adminFactory
            ->expects($this->once())
            ->method('createFromRequest')
            ->with($request)
            ->willReturn($admin)
        ;
        $dataProviderFactory
            ->expects($this->once())
            ->method('get')
            ->with('my_little_provider')
            ->willReturn($provider)
        ;

        $router
            ->expects($this->once())
            ->method('generate')
            ->with('my_routing_pattern.my_admin.'.$actionName)
            ->willReturn('http://fake-url.com')
        ;

        $translator
            ->expects($this->once())
            ->method('trans')
            ->with('cms.article.default_title')
            ->willReturn('My New Message !!!')
        ;

        $response = $controller->__invoke($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('http://fake-url.com', $response->getTargetUrl());

        $this->assertEquals('My New Message !!!', $entity->getTitle());
        $this->assertEquals(Article::PUBLICATION_STATUS_DRAFT, $entity->getPublicationStatus());
    }

    public function actionProvider()
    {
        return [
            ['edit'],
            ['list'],
        ];
    }

    /**
     * @return CreateArticleAction[]|MockObject[]
     */
    private function createController()
    {
        $adminFactory = $this->createMock(AdminFactory::class);
        $dataProviderFactory = $this->createMock(DataProviderFactory::class);
        $translator = $this->createMock(TranslatorInterface::class);
        $router = $this->createMock(RouterInterface::class);

        $controller = new CreateArticleAction(
            $adminFactory,
            $dataProviderFactory,
            $translator,
            $router
        );

        return [
            $controller,
            $adminFactory,
            $dataProviderFactory,
            $translator,
            $router,
        ];
    }
}
