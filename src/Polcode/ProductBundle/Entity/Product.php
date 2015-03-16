<?php

namespace Polcode\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity 
 * @ORM\Entity(repositoryClass="Polcode\ProductBundle\Entity\ProductRepository")
 */
class Product {

    use ORMBehaviors\Translatable\Translatable;

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue */
    private $id;

    /** @ORM\Column(type="decimal", scale=2) */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products",cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
     * */
    private $category;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    public function __toString() {
        return $this->getName();
    }
    
    public function getName() {
        return $this->proxyCurrentLocaleTranslation('getName', array());
    }
    
    public function getDescription() {
        return $this->proxyCurrentLocaleTranslation('getDescription', array());
    }
    
    public function getSlug() {
        return $this->proxyCurrentLocaleTranslation('getSlug', array());
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Product
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set category
     *
     * @param \Polcode\ProductBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\Polcode\ProductBundle\Entity\Category $category = null) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Polcode\ProductBundle\Entity\Category 
     */
    public function getCategory() {
        return $this->category;
    }

}
