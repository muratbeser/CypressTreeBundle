<?php
/**
 * User: matteo
 * Date: 23/03/12
 * Time: 15.01
 *
 * Just for fun...
 */

namespace Cypress\TreeBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

use Cypress\TreeBundle\Interfaces\TreeControllerSortableInterface;

/**
 * Controller per NestedSet
 */
class SonataAdminTreeController extends CRUDController implements TreeControllerSortableInterface
{
    /**
     * Action per la lista
     *
     * @throws AccessDeniedException
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();
        $roots = $this->getTreeRepository()->getRootNodes();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getListTemplate(), array(
            'action'     => 'list',
            'roots'      => $roots,
        ));
    }

    /**
     * recupera il repository dell'entità
     *
     * @return NestedTreeRepository
     */
    public function getTreeRepository()
    {
        return $this->get('doctrine.orm.entity_manager')->getRepository($this->admin->getClass());
    }

    /**
     * Controller action to move a tree node
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response must return a Response object with:
     *     "ok": everything worked
     *     "ko": there was a problem
     */
    function sortNodeAction()
    {
        return new \Symfony\Component\HttpFoundation\Response('ko');
    }
}
