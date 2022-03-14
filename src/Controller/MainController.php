<?php


namespace App\Controller;

use App\Entity\Cerveza;
use App\Form\CerveType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{

    #[Route('/cerveza/{id}', name:"showCerveza")]
    public function showCerveza($id, EntityManagerInterface $doctrine)
    {
            $repo = $doctrine ->getRepository(Cerveza::class);
            $cerveza = $repo -> find($id);

        // $cerveza = [
        //     "marca"=>"Cerveza Bud Light",
        //     "tipo"=>"Lager",
        //     "descripcion"=>"Esta bebida amarilla contiene pocas calorías y su grado de alcohol es de 4.2%.  A pesar de no tener muchos años de trayectoria en comparación a otras cervezas que veremos luego, Bud Light ha alcanzado gran popularidad en muchos países; siendo jóvenes y mujeres la población que más consume de esta bebida.",
        //     "img"=>"https://www.cervezataf.com/wp-content/uploads/2021/05/cerveza-bud-light.jpg",
            
        // ];
        return $this->render('cervezas/showCerveza.html.twig', ["cerveza"=>$cerveza]);
    }

    #[Route('/cervezas', name : "listCervezas")]
    public function listCerveza(EntityManagerInterface $doctrine)
    {

            $repo=$doctrine ->getRepository(Cerveza::class);
            $cervezas= $repo ->findAll();

      

        return $this->render('cervezas/listCerveza.html.twig', ["cervezas"=>$cervezas]);
    }

    #[Route('/insert/cerveza')]
    public function insertCerveza(EntityManagerInterface $doctrine, Request $request){

      

        $cerveza  = new Cerveza();
        $cerveza -> setMarca("Snow");
        $cerveza -> setTipo("Lager");
        $cerveza -> setDescripcion(("Su nombre significa nieve en inglés y es otorgado debido a la consistencia espumosa y blanca que toma esta bebida al ser servida. Es de tipo lager y su sabor es suave."));
        $cerveza -> setImg('https://www.cervezataf.com/wp-content/uploads/2021/05/cerveza-snow.jpg');

        $doctrine ->persist ($cerveza);


        $cerveza2  = new Cerveza();
        $cerveza2 -> setMarca("Edge Brewing");
        $cerveza2 -> setTipo("Artesana");
        $cerveza2 -> setDescripcion(("A pesar de ser un producto que apenas comenzaba a surgir, en el 2015 se logró calificar como “la mejor nueva cervecera del mundo”. Un reconocimiento otorgado por RateBeer."));
        $cerveza2 -> setImg('http://4179a61jt38h3m71pe6io81k.wpengine.netdna-cdn.com/wp-content/uploads/2016/03/home-beer_Mar2016.png');

        $doctrine ->persist ($cerveza2);
        $doctrine ->flush();

        return $this->render ('cervezas/showCerveza.html.twig', ['cerveza2' =>$cerveza2]);
    }

    #[Route('/new/cerveza', name:'newCerveza')]

    public function newCerveza (Request $request, EntityManagerInterface $doctrine)
    {
        $form = $this -> createForm(CerveType::class);
        $form -> handleRequest ($request);

        if($form -> isSubmitted()&& $form ->isValid()){
            $cerveza = $form ->getData();
       
        $doctrine ->persist ($cerveza);
        $doctrine ->flush();

        $this -> addFlash('Añadida', 'CERVEZA AÑADIDA CORRECTAMENTE');
        return $this -> redirectToRoute('showCerveza',['id' => $cerveza -> getId()] );
 }
        return $this -> renderForm('cervezas/insertCerveza.html.twig', ['cervezaForm' => $form ]);
    }

    #[Route('/delete/cerveza/{id}', name:'deleteCerveza')]
    public function deleteCerveza($id, EntityManagerInterface $doctrine)
    {
        $user = $this->getUser();

        $repo = $doctrine->getRepository(Cerveza::class);
        $cerveza = $repo->find($id);

        $doctrine->remove($cerveza);
        $doctrine->flush();

        return $this->redirectToRoute("listCervezas");
    }



};