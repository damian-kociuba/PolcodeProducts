<?php

namespace Polcode\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Entity 
 * @ORM\Entity(repositoryClass="Polcode\ProductBundle\Entity\ProductRepository")
 * @Gedmo\TranslationEntity(class="Polcode\ProductBundle\Entity\ProductTranslation")
 */
class Product implements Translatable {

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue */
    private $id;

    /** @ORM\Column(type="decimal", scale=2) */
    private $price;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string") 
     */
    private $name;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @ORM\OneToMany(
     * targetEntity="ProductTranslation",
     * mappedBy="object",
     * cascade={"persist", "remove"}
     * )
     */
    private $translations;

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
    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    public function __toString() {
        return $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Product
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add translations
     *
     * @param \Polcode\ProductBundle\Entity\ProductTranslation $translations
     * @return Product
     */
    public function addTranslation(\Polcode\ProductBundle\Entity\ProductTranslation $translations)
    {
        $this->translations[] = $translations;
        $translations->setObject($this);
        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Polcode\ProductBundle\Entity\ProductTranslation $translations
     */
    public function removeTranslation(\Polcode\ProductBundle\Entity\ProductTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Set category
     *
     * @param \Polcode\ProductBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\Polcode\ProductBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Polcode\ProductBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
