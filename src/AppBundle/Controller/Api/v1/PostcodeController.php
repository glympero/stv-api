<?php

namespace AppBundle\Controller\Api\v1;


use AppBundle\Controller\BaseController;
use AppBundle\Service\distanceCalculator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PostcodeController extends BaseController
{
    /**
     * @Route("/host/postcodes/{postcode}")
     * @Method("GET")
     */
    public function postCodeAction($postcode)
    {
        $this->validateInputs($postcode);

        $postCode = $this->getPostcodeFromDB($postcode);

        if($postCode === null) {
            $this->throw404("No results found.");
        }

        $data = [
            'postcode' => $this->addWhiteSpaceToPostcode($postCode->getPostcode()),
            'eastings' => $postCode->getEastings(),
            'northings' => $postCode->getNorthings(),
        ];

        $response = $this->createApiResponse($data, 201);
        return $response;
    }

    /**
     * @Route("/host/distance/", name="distance")
     * @Method("GET")
     */
    public function distanceAction(Request $request)
    {
        $postcodes=$request->query->get('postcode');

        $distanceCalculator = new distanceCalculator();

        $result = array();

        foreach ($postcodes as $value) {
            $this->validateInputs($value);
            $pd = $this->getPostcodeFromDB($value);

            if($pd === null) {
                $this->throw422();
            }

            $result[] = ['postcode' => $this->addWhiteSpaceToPostcode($value), 'distance' => $distanceCalculator->getDistanceFromPQ($pd->getEastings(), $pd->getNorthings())];
        }

        //Order DESC
        usort($result, function($a, $b) {
            if ($a['distance'] == $b['distance']) return 0;
            return $a['distance'] < $b['distance'] ? -1 : 1;
        });

        $response = $this->createApiResponse($result, 201);
        return $response;
    }


    /**
     * @param $postcode
     */
    private function validateInputs($postcode)
    {
        if (!$postcode || $postcode === '' || !is_string($postcode) || is_numeric(($postcode))) {
            $this->throw422();
        }
    }

    /**
     * @param $string
     * @return string
     */
    private function addWhiteSpaceToPostcode($string)
    {
        $end = substr($string, -3);
        $start = substr($string, 0, -3);
        return $start. ' '. $end;
    }

    /**
     * @param $string
     * @return mixed
     */
    private function removeWhiteSpaceFromPostcode($string)
    {
        return preg_replace('/\s+/', '', $string);
    }

    /**
     * Safe from SQL injection
     *
     * @param $postcode
     * @return \AppBundle\Entity\Postcode|null|object
     */
    private function getPostcodeFromDB($postcode)
    {
        return $this->getDoctrine()
            ->getRepository('AppBundle:Postcode')
            ->findOneBy(['postcode' => $this->removeWhiteSpaceFromPostcode($postcode)]);
    }
}