<?php

/**
 * Comments class
 * 
 */


Class Comments {

   public static function form($file_id)
   {
     $commentsM = new Model_Comments();

     $data = array(
         'comments' => $commentsM->getComm($file_id),
         'fileid' =>$file_id
     );
     echo View::instance('comment',$data);
   }

   public static function getByParentId($file_id,$pad=0, $html='')
   {
       $commentsM = new Model_Comments();

       if($comments = $commentsM->getCommByParent($file_id))
       {
           $pad = ($pad==0)? 1 : $pad + 1;

           foreach($comments as $com)
           {
            $data = array(
              'comm' =>$com,
              'padding' => $pad
            );
            $html.=View::instance('commentParent',$data);
            $html.=self::getByParentId($com->id,$pad);
           }
           
       }

       return $html;

   }

}
?>
