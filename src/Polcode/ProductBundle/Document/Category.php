<?php

namespace Polcode\ProductBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * @MongoDB\Document
 */
class Category {

    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /** @MongoDB\Field(type="string") */
    protected $name;

    /** @MongoDB\EmbedMany(targetDocument="Product") */
    protected $products;

    /** 
     * @MongoDB\Field(type="timestamp") 
     * @Gedmo\Timestampable(on="create")
     */
    protected $creationTimestamp;
    
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add product
     *
     * @param Polcode\ProductBundle\Document\Product $product
     */
    public function addProduct(\Polcode\ProductBundle\Document\Product $product)
    {
        $this->products[] = $product;
    }

    /**
     * Remove product
     *
     * @param Polcode\ProductBundle\Document\Product $product
     */
    public function removeProduct(\Polcode\ProductBundle\Document\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return Doctrine\Common\Collections\Collection $products
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set creationTimestamp
     *
     * @param timestamp $creationTimestamp
     * @return self
     */
    public function setCreationTimestamp($creationTimestamp)
    {
        $this->creationTimestamp = $creationTimestamp;
        return $this;
    }

    /**
     * Get creationTimestamp
     *
     * @return timestamp $creationTimestamp
     */
    public function getCreationTimestamp()
    {
        return $this->creationTimestamp;
    }
}
