<?php

namespace JK\CmsBundle\Form\Transformer;

use JK\CmsBundle\Entity\Tag;
use JK\CmsBundle\Repository\TagRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagCollectionTransformer implements DataTransformerInterface
{
    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * TagCollectionTransformer constructor.
     *
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param Tag[] $tags
     *
     * @return string
     */
    public function transform($tags)
    {
        if (!is_array($tags) && !$tags instanceof Collection) {
            throw new TransformationFailedException(
                'Only an array or a Collection can be transformed, given '.gettype($tags)
            );
        }
        $content = [];

        foreach ($tags as $tag) {
            $content[] = $tag->getName();
        }

        return implode(', ', $content);
    }

    /**
     * @param string $tagsString
     *
     * @return array
     */
    public function reverseTransform($tagsString)
    {
        if (!$tagsString) {
            return [];
        }

        if (!is_string($tagsString)) {
            throw new TransformationFailedException(
                'Only a string containing Tag names can be reversed, '.gettype($tagsString).' given'
            );
        }
        $names = explode(',', $tagsString);
        $tags = [];

        foreach ($names as $name) {
            $name = trim($name);
            $tag = $this
                ->tagRepository
                ->findOneBy([
                    'name' => $name,
                ]);

            if (null === $tag) {
                $tag = new Tag();
                $tag->setName($name);

                $this
                    ->tagRepository
                    ->save($tag)
                ;
            }
            $tags[] = $tag;
        }

        return $tags;
    }
}
