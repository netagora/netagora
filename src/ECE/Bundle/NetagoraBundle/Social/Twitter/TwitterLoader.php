<?php

namespace ECE\Bundle\NetagoraBundle\Social\Twitter;

use ECE\Bundle\NetagoraBundle\Entity\Publication;
use ECE\Bundle\NetagoraBundle\Entity\User;

class TwitterLoader
{
    private $data;
    private $user;
    private $publications;

    public function __construct(User $user)
    {
        $this->publications = array();
        $this->user = $user;
    }

    public function load($data)
    {
        foreach ($data as $tweet) {
            $publication = new Publication();
            $this->hydrate($publication, $tweet);
            if ($publication->getLinkUrl()) {
                $this->publications[] = $publication;
            }
        }
    }

    public function getPublications()
    {
        return $this->publications;
    }

    private function hydrate(Publication $publication, $tweet)
    {
        if (1 !== preg_match('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $tweet->text, $links)) {
            return $publication;
        }

        $publication->setUser($this->user);
        $publication->setSocialNetwork(Publication::TWITTER);
        $publication->setAuthor($tweet->user->name);
        $publication->setAuthorScreenName($tweet->user->screen_name);
        $publication->setPublishedAt(new \DateTime($tweet->created_at));
        $publication->setAuthorPicture($tweet->user->profile_image_url_https);
        $publication->setReference($tweet->id_str);
        $publication->setContent($tweet->text);
        $publication->setLinkUrl($links[0]);

        return $publication;
    }
}