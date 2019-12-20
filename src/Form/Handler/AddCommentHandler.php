<?php

namespace JK\CmsBundle\Form\Handler;

use JK\CmsBundle\DependencyInjection\Helper\ConfigurationHelper;
use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Entity\Comment;
use JK\CmsBundle\Manager\CommentManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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

    public function __construct(
        string $contactEmail,
        CommentManagerInterface $manager,
        TranslatorInterface $translator,
        MailerInterface $mailer,
        ConfigurationHelper $helper
    ) {
        $this->manager = $manager;
        $this->contactEmail = $contactEmail;
        $this->translator = $translator;
        $this->mailer = $mailer;
        $this->helper = $helper;
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
            $from = 'unknown@lecomptoirdelecureil.fr';
        }
        $subject = $this->translator->trans('cms.new_comment.subject', [
            ':application' => $this->helper->getApplicationName(),
            ':article' => $comment->getArticle()->getTitle(),
        ], 'mailing');

        $email = (new TemplatedEmail())
            ->to($this->contactEmail)
            ->from($from)
            ->subject($subject)
            ->htmlTemplate('@JKCms/Mail/Notifications/new-comment.html.twig')
            ->context([
                'comment' => $comment,
                'subject' => $subject,
                'base' => $this->helper->getMailingBaseTemplate(),
            ])
        ;
        $this->mailer->send($email);
    }
}
