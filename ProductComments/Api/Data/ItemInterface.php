<?php

namespace Dev\ProductComments\Api\Data;

interface ItemInterface
{
    /**
     * @return string | null
     */
    public function getFirstName();

    /**
     * @return string | null
     */
    public function getLastName();

    /**
     * @return string | null
     */
    public function getEmail();

    /**
     * @return string | null
     */
    public function getCreatedAt();

    /**
     * @return string | null
     */
    public function getComment();

    /**
     * @return boolean | null
     */
    public function getStatus();
}
