<?php

namespace Polcode\ProductBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Polcode\ProductBundle\Form\ProductType;

class ProductAdmin extends Admin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('price')
                ->add('category', 'sonata_type_model_list')
                ->add('translations', 'a2lix_translations'); // [5.a - Mandatory]
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                //->add('name')
                ->add('price')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('name')
                ->add('price')
                ->add('description')
                ->add('slug')
                ->add('category.name')
        ;
    }

}
