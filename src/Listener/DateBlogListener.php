<?php

namespace App\Doctrine\Subscriber;

use App\Entity\Blog;
use DateTime;


class DateBlogListener
{





    public function __construct()
    {
    }

    public function prePersist(Blog $blog)
    {
        $blog->setCreatedAt(new DateTime('now'));
    }
}
