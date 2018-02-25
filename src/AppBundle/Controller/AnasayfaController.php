<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ApiResults;
//use http\Env\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnasayfaController extends Controller
{

    /**
     * @Route("/anasayfa", name="anasayfa")
     */
    public function HomePage(Request $request)
    {
        /*
        $result =$this->getDoctrine()
            ->getRepository(ApiResults::class)
            ->createQueryBuilder('a')
            ->select('a.fromThe, a.moneyType, a.amount')
            ->groupBy('a.fromThe')
            ->addGroupBy('a.moneyType')
            ->setMaxResults(6)
            ->orderBy('a.id','desc')
            ->getQuery()
            ->getResult();
    */
        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = 'SELECT moneyType,amount, fromThe  FROM `api_results`
                      group by fromThe,moneyType
                      ORDER by amount';

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        $r = $statement->fetchAll();

        $minExchanges=array();
        for ($i =0; $i<count($r); $i=$i+2){
            array_push($minExchanges,$r[$i]);
        }
        //var_dump($minExchanges); die();
        //return $this->render('default/kullanici.html.twig',['minExchanges'=>$minExchanges]);
        return new Response('<html>
        <head><h1>En Düşük Kurlar</h1></head>
        <bodoy>
            <table border="1">
                <tr>
                    <th>Dolar</th>
                    <th>Euro</th>
                    <th>Sterlin</th>
                </tr>
                <tr>
                    <td>'.$minExchanges[0]["amount"].'</td>
                    <td>'.$minExchanges[1]["amount"].'</td>
                    <td>'.$minExchanges[2]["amount"].'</td>
                </tr>
            </table>
        </bodoy></html>');


    }




    /**
     * @Route("/api1", name="api1")
     */
    public function indexAction(Request $request)
    {
        $ch = curl_init(); //http://www.mocky.io/v2/5a74524e2d0000430bfe0fa3
        curl_setopt($ch, CURLOPT_URL, 'http://www.mocky.io/v2/5a74519d2d0000430bfe0fa0');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $data = json_decode($response,true);
        //var_dump($data); die();
        if(isset($data['result'])) {
            $data = $data['result'];
        }
        var_dump($data[0]['amount']); die();

        if(isset($data[0]['amount'])) {echo isset($data[0]['amount']);}


        for($i=0; $i<count($data); $i++){
            $kur = new ApiResults();
            if ($i == 0) $moneyType = "Dolar";
            if ($i == 1) $moneyType = "Euro";
            if ($i == 2) $moneyType = "Sterlin";
            $kur->setMoneyType($moneyType);
            if(isset($data[$i]['amount']) || $data[$i]['oran']){
                if (isset($data[$i]['amount']) ) $amount =$data[$i]['amount'];
                if (isset($data[$i]['oran']) ) $amount =$data[$i]['oran'];
                $kur->setAmount($amount);
            }
            $fromThe = substr('http://www.mocky.io/v2/5a74519d2d0000430bfe0fa0',-5);

            $kur->setFromThe($fromThe);
            $em =$this->getDoctrine()->getManager();
            $em->persist($kur);
            $em->flush();
        }

     //   return $this->render('default/kullanici.html.twig', ['data' =>$data,'a'=>$a]);
        return new Response('<html><bodoy>Yüklendi</bodoy></html>');
    }

    /**
     * @Route("/api2", name="api2")
     */
    public function otherAction(Request $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.mocky.io/v2/5a74524e2d0000430bfe0fa3');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $data = json_decode($response,true);
        //var_dump($data); die();
        if(isset($data['result'])) {
            $data = $data['result'];
        }

        for($i=0; $i<count($data); $i++){
            $kur = new ApiResults();
            if ($i == 0) $moneyType = "Dolar";
            if ($i == 1) $moneyType = "Euro";
            if ($i == 2) $moneyType = "Sterlin";
            $kur->setMoneyType($moneyType);
            if(isset($data[$i]['amount']) || $data[$i]['oran']){
                if (isset($data[$i]['amount']) ) $amount =$data[$i]['amount'];
                if (isset($data[$i]['oran']) ) $amount =$data[$i]['oran'];
                $kur->setAmount($amount);
            }
            $fromThe = substr('http://www.mocky.io/v2/5a74524e2d0000430bfe0fa3',-5);

            $kur->setFromThe($fromThe);
            $em =$this->getDoctrine()->getManager();
            $em->persist($kur);
            $em->flush();
        }

        //   return $this->render('default/kullanici.html.twig', ['data' =>$data,'a'=>$a]);
        return new Response('<html><bodoy>Yüklendi</bodoy></html>');
    }
}
