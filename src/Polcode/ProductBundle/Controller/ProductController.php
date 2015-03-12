<?php

namespace Polcode\ProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Polcode\ProductBundle\Entity\Product;
use Polcode\ProductBundle\Form\ProductType;

/**
 * Product controller.
 *
 * @Route("/product")
 */
class ProductController extends Controller {

    /**
     * @Route("/test", name="product_test")
     */
    public function testAction() {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("PolcodeProductBundle:Product");
        
        $prod1 = new Product();
        $prod1->setName('name');
        $prod1->setPrice(12.88);
        $prod1->setDescription('desc');
        $transPl = new \Polcode\ProductBundle\Entity\ProductTranslation('pl_pl', 'name', 'Nazwa');
        $transEN = new \Polcode\ProductBundle\Entity\ProductTranslation('en_en', 'name', 'Nejm');
        $prod1->addTranslation($transPl);
        $prod1->addTranslation($transEN);
        
        $cat = new \Polcode\ProductBundle\Entity\Category();
        $cat->setName('nazw');
        $prod1->setCategory($cat);
        /*$product = $em->find('Polcode\ProductBundle\Entity\Product', 3);
        $product->setName('my title in de');
        $product->setDescription('my content in de');
        $product->setTranslatableLocale('de_de'); // change locale
         * 
         */
        $em->persist($transEN);
        $em->persist($transPl);
        $em->persist($prod1);
        $em->flush();
    }

    /**
     * Lists all Product entities.
     *
     * @Route("/", name="product")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PolcodeProductBundle:Product')->findAll();
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Product entity.
     *
     * @Route("/", name="product_create")
     * @Method("POST")
     * @Template("PolcodeProductBundle:Product:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Product();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('product_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Product entity.
     *
     * @param Product $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Product $entity) {
        $form = $this->createForm(new ProductType(), $entity, array(
            'action' => $this->generateUrl('product_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/new", name="product_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Product();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PolcodeProductBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/slug/{slug}", name="product_show_by_slug")
     * @Method("GET")
     * @Template("PolcodeProductBundle:Product:show.html.twig")
     */
    public function showBySlugAction($slug) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PolcodeProductBundle:Product')->findOneBy(array('slug' => $slug));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PolcodeProductBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Product entity.
     *
     * @param Product $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Product $entity) {
        $form = $this->createForm(new ProductType(), $entity, array(
            'action' => $this->generateUrl('product_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Product entity.
     *
     * @Route("/{id}", name="product_update")
     * @Method("PUT")
     * @Template("PolcodeProductBundle:Product:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PolcodeProductBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('product_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PolcodeProductBundle:Product')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('product'));
    }

    /**
     * Creates a form to delete a Product entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('product_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
