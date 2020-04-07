<?php

namespace JK\CmsBundle\Form\Handler;

use JK\CmsBundle\DependencyInjection\Helper\ConfigurationHelper;
use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Entity\Comment;
use JK\CmsBundle\Manager\CommentManagerInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class AddCommentHandler
{
    /**
     * @var CommentManagerInterface
     */
    private $manager;

    /**
     * @var string
     */
    private $contactEmail;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var ConfigurationHelper
     */
    private $helper;

    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(
        string $contactEmail,
        CommentManagerInterface $manager,
        TranslatorInterface $translator,
        MailerInterface $mailer,
        ConfigurationHelper $helper,
        Environment $environment,
        RouterInterface $router
    ) {
        $this->manager = $manager;
        $this->contactEmail = $contactEmail;
        $this->translator = $translator;
        $this->mailer = $mailer;
        $this->helper = $helper;
        $this->environment = $environment;
        $this->router = $router;
    }

    public function handle(array $data, Article $article): void
    {
        $comment = $this->manager->getFactory()->create(
            $data['authorName'],
            $data['content'],
            $data['notifyNewComments'],
            $data['authorUrl'],
            $data['authorEmail']
        );
        $comment->setArticle($article);
        $this->manager->save($comment);

        $this->sendEmail($comment);
    }

    private function sendEmail(Comment $comment): void
    {
        $from = $comment->getAuthorEmail();

        if (!$from) {
            $from = 'unknown-sender@lecomptoirdelecureil.fr';
        }
        $subject = $this->translator->trans('cms.new_comment.subject', [
            ':application' => $this->helper->getApplicationName(),
            ':article' => $comment->getArticle()->getTitle(),
        ], 'mailing');
        $message = $this->translator->trans('cms.new_comment.message', [
            ':article_title' => $comment->getArticle()->getTitle(),
            ':content' => $comment->getContent(),
            ':author_name' => $comment->getAuthorName(),
        ], 'mailing');

        $email = (new NotificationEmail())
            ->from($from)
            ->to($this->contactEmail)
            ->subject($subject)
            ->markdown($message)
            ->importance(NotificationEmail::IMPORTANCE_MEDIUM)
            ->action(
                $this->translator->trans('cms.new_comment.see_comment', [], 'mailing'),
                $this->router->generate($this->helper->getShowRoute(), $this->getShowRouteParameters($comment->getArticle()))
            )
            ->importance(NotificationEmail::IMPORTANCE_HIGH)
        ;

        $this->mailer->send($email);
    }

    private function getShowRouteParameters(Article $article): array
    {
        $accessor = new PropertyAccessor();
        $parameters = [];

        foreach ($this->helper->getShowRouteParameters() as $name => $property) {
            $parameters[$name] = $accessor->getValue($article, $property);
        }

        return $parameters;
    }
}
