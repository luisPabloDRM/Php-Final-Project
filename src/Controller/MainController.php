<?php


namespace App\Controller;

use App\Entity\Cerveza;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{

    #[Route('/cerveza')]
    public function showCerveza()
    {
        $cerveza = [
            "marca"=>"Cerveza Bud Light",
            "tipo"=>"Lager",
            "descripcion"=>"Esta bebida amarilla contiene pocas calorías y su grado de alcohol es de 4.2%.  A pesar de no tener muchos años de trayectoria en comparación a otras cervezas que veremos luego, Bud Light ha alcanzado gran popularidad en muchos países; siendo jóvenes y mujeres la población que más consume de esta bebida.",
            
        ];
        return $this->render('cerveza/showCerveza.twig', ["cerveza"=>$cerveza]);
    }

    #[Route('/cervezas')]
    public function listCerveza()
    {
        $cervezas = [
            ["marca"=>"Stella Artois",
            "tipo"=>"Lager",
            "descripcion"=>"Su color dorado brillante, espuma consistente y el característico sabor de la cerveza tipo lager provoca interés en los amantes de esta bebida. Logrando generar competencia con los grandes mercados de Estados Unidos y de Reino Unido."],


            ["marca"=>"Heineken",
            "tipo"=>"Lager",
            "descripcion"=>"Se considera una bebida de muy alta calidad, siendo esta marca la responsable de impulsar el consumo de la cerveza en más de 150 países.  Es una de las cervezas más vendidas en toda Europa, logrando gran alcance en el mercado americano y asiático donde existe una competencia considerable."],


            ["marca"=>"Budweiser",
            "tipo"=>"Lager",
            "descripcion"=>"Su proceso de elaboración de 30 días y su maduración en virutas de madera de haya le da un sabor característico que muchos demandan continuamente."],

        ];

        return $this->render('cervezas/listCerveza.html.twig', ["cervezas"=>$cervezas]);
    }

    #[Route('/insert/cerveza')]
    public function insertPokemon(EntityManagerInterface $doctrine){

        $cerveza  = new Cerveza();
        $cerveza -> setMarca("Snow");
        $cerveza -> setTipo("Lager");
        $cerveza -> setDescripcion(("Su nombre significa nieve en inglés y es otorgado debido a la consistencia espumosa y blanca que toma esta bebida al ser servida. Es de tipo lager y su sabor es suave."));

        $doctrine ->persist ($cerveza);


        $cerveza2  = new Cerveza();
        $cerveza2 -> setMarca("Edge Brewing");
        $cerveza2 -> setTipo("Artesana");
        $cerveza2 -> setDescripcion(("A pesar de ser un producto que apenas comenzaba a surgir, en el 2015 se logró calificar como “la mejor nueva cervecera del mundo”. Un reconocimiento otorgado por RateBeer."));

        $doctrine ->persist ($cerveza2);
        $doctrine ->flush();
    }


};