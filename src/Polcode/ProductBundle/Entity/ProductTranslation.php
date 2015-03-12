<?php

namespace Polcode\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity 
 * @ORM\Table(
 * uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 * "locale", "object_id", "field"
 * })}
 * )
 */
class ProductTranslation extends AbstractPersonalTranslation {

    /**
     * Convinient constructor
     *
     * @param string $locale
     * @param string $field
     * @param string $value
     */
    public function __construct($locale = null, $field = null, $value = null) {
        if ($locale !== null) {
            $this->setLocale($locale);
        }
        if ($field !== null) {
            $this->setField($field);
        }
        if ($value !== null) {
            $this->setContent($value);
        }
    }

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;

}
