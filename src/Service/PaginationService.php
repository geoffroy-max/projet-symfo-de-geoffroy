<?php
      namespace App\Service;



   use App\Entity\Booking1;
   use Doctrine\ORM\EntityManagerInterface;
   use mysql_xdevapi\Exception;
   use Symfony\Component\HttpFoundation\Request;
   use Symfony\Component\HttpFoundation\RequestStack;
   use Twig\Environment;

   class   PaginationService{
      private $entityClass;
      private $limit= 10;
      private $currentPage= 1;
      private $manager;
      private $twig;
      private $route;
      private $templatePath;

   public function __construct(EntityManagerInterface $manager , Environment $twig, RequestStack $request ,$templatePath){
        $this->route= $request->getCurrentRequest()->attributes->get('_route');

        $this->manager= $manager;
        $this->twig = $twig;
        $this->templatePath= $templatePath;
      }

       public function setTemplatePath($templatePath){
       $this->templatePath= $templatePath;
       return $this;
       }

       public function getTemplatePath(){
        return $this->templatePath;
       }
      public function setroute($route){
       $this->route= $route;
       return $this;
      }

       /**
        * @return mixed
        */
       public function getRoute()
       {
           return $this->route;
       }

      public function display(){
       $this->twig->display($this->templatePath , [
           'page'=>$this->currentPage,
           'pages'=>$this->getPages(),
           'route'=> $this->route,


       ]);
      }

       public function getPages(){

       // connaitre le nombre d'engregistrement da la table dns bd
       $repo= $this->manager->getRepository($this->entityClass);
           $total =count($repo->findAll()) ;
           // connaitre le nbre de pagination
       $pages= ceil($total/ $this->limit);
       return $pages;
       }
      public function getData(){
          if(empty($this->entityClass)){
              throw new \ Exception("vous n'avez pas specifier l entité dans le controller d'annonce sur laquelle nous devons paginer!
               utilisé la mehtode setEntityclasse() de votre objet de pagination");
          }
       // calculer l offset
        $offset= $this->currentPage*$this->limit - $this->limit;
        //demander au repository de trouver les elmnt dns la bd de donnée
          $repos=$this->manager->getRepository($this->entityClass);
          $data= $repos->findBy([],[],$this->limit,$offset);
          return $data;
      }

      public function setEntityClass($entityClass){
          $this->entityClass= $entityClass;
          return $this;
      }
      public function getEntityClass(){
          return $this->entityClass;
      }

     public function setLimit($limit){
          $this->limit= $limit;
          return $this;
      }
      public  function getLimit(){
          return $this->limit;
      }
     public function setPage($page){
          $this->currentPage= $page;
          return $this;
       }
    public function getPage(){
       return $this->currentPage;
    }

   }