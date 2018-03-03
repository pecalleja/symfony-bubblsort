<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $session = $this->get('session');

        //if the values are not in session generate them and store
        if(!$session->has('unsorted'))
        {
            $values = $this->generateRandomNumbers();
            $session->set('unsorted', $values);
            $session->set('processing', $values);
            $session->set('fin', false);
            $session->set('swap', false);
            $session->set('i', 0);
            $session->set('j', 0);
        }

        $unsorted = $session->get('unsorted');
        $processing = $session->get('processing');

        $shuffleForm = $this->createShuffleForm();
        $stepForm = $this->createStepForm();

        return $this->render('bubblsort/index.html.twig', array(
            'unsorted' => $unsorted,
            'processing' => $processing,
            'j' => $session->get('j'),
            'fin' => $session->get('fin'),
            'shuffleForm' => $shuffleForm->createView(),
            'stepFrom' => $stepForm->createView()
        ));
    }

    /**
     * Step process.
     *
     * @Route("/step", name="step")
     * @Method("PUT")
     */
    public function stepAction(Request $request)
    {
        $form = $this->createStepForm();
        $form->handleRequest($request);
        $session = $this->get('session');
        $processing = $session->get('processing');
        $i = $session->get('i');
        $j = $session->get('j');
        if ($form->isSubmitted() && $form->isValid()) {
            if($i < 9){
                if($j<9-$i){
                    if($processing[$j] > $processing[$j+1]){
                        $temp = $processing[$j];
                        $processing[$j] = $processing[$j+1];
                        $processing[$j+1] = $temp;
                    }
                    $j++;
                }else{
                    $i++;
                    $j=0;
                }
            }else{
                $session->set('fin', true);
            }

            $session->set('processing', $processing);
            $session->set('i', $i);
            $session->set('j', $j);
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * Shuffle elements.
     *
     * @Route("/shuffle", name="shuffle")
     * @Method("PUT")
     */
    public function shuffleAction(Request $request)
    {
        $form = $this->createShuffleForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session = $this->get('session');
            $values = $this->generateRandomNumbers();
            $session->set('unsorted', $values);
            $session->set('processing', $values);
            $session->set('i', 0);
            $session->set('j', 0);
            $session->set('fin', false);
            $session->set('swap', false);
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * Creates a form to shuffle numbers.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createShuffleForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('shuffle'))
            ->setMethod('PUT')
            ->getForm()
            ;
    }

    /**
     * Creates a form to run one step in the process.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createStepForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('step'))
            ->setMethod('PUT')
            ->getForm()
            ;
    }

    private function generateRandomNumbers($n=10)
    {
        $unsorted = [];
        for ($i=0; $i<$n; $i++)
        {
            $unsorted[$i] = rand(0,100);
        }
        return $unsorted;
    }
}
