<?php
function ghref($param){
	parse_str($_SERVER['QUERY_STRING'],$myArray);
	$myArray = array_diff($myArray, array(''));
	$myArray['page']=$param;
	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	return substr($url,0,strpos($url,"?"))."?".str_replace("%2F","/",http_build_query($myArray));
}
class Fenye
{
    public $page_size; //每页条数
    public $page; //第几页
    public $page_count; //总页数
    public $num; //总条数
    function __construct($count, $page_size)
    {
        $this->page       = 1;
        $this->num        = $count;
        $this->page_size  = $page_size;
        $this->page_count = ceil($this->num / $this->page_size);
    }
    function show()
    {
	      $this->page = empty($_REQUEST['page'])?1:$_REQUEST['page'];
	    	$array_list=array(1,2,3,4);
	      if(in_array($this->page,$array_list)){
	      		$array = array();
	      		array_push($array, "<a href=".ghref(1).">首</a>");
	      		if($this->page + 3>=$this->page_count)
	      			$page_tmp=$this->page_count;
	      		else
	      			$page_tmp=$this->page + 3;
	      		for ($i = 1; $i <= $page_tmp; $i++) {
	          	array_push($array, "<a style='*position:relative;*top:1px;' class=fy".$i." href=".ghref($i).">$i</a>");
	      		}
	      		if(($this->page + 3<$this->page_count) && ($page_tmp+1<$this->page_count)){
	      			array_push($array, "<a style='*position:relative;*top:1px;' class=fy".$this->page_count." href=".ghref($this->page_count).">...".$this->page_count."</a>");
	      		}if(($this->page + 3<$this->page_count) && ($page_tmp+1==$this->page_count)){
	      			array_push($array, "<a style='*position:relative;*top:1px;' class=fy".$this->page_count." href=".ghref($this->page_count).">".$this->page_count."</a>");
	      		}
	      		array_push($array, "<a href=".ghref($this->page_count).">末</a>");
	    	}else{
		    	if($this->page == $this->page_count){
		      		$array = array();
		      		array_push($array, "<a href=".ghref(1).">首</a>");
		      		if($this->page-5>0){
		      			array_push($array, "<a style='*position:relative;*top:1px;' class=fy1 href=".ghref(1).">1...</a>");
		      		}else{
		      			array_push($array, "<a style='*position:relative;*top:1px;' class=fy1 href=".ghref(1).">1</a>");	
		      		}
		      		for ($i = $this->page-3; $i <= $this->page; $i++) {
		          	array_push($array, "<a style='*position:relative;*top:1px;' class=fy".$i." href=".ghref($i).">$i</a>");
		      		}
		      		array_push($array, "<a href=".ghref($this->page_count).">末</a>");
		    		}else{
		    			if($this->page < $this->page_count-3){
		    			     $array = array();
		    			     array_push($array, "<a href=".ghref(1).">首</a>");
		    			     if($this->page-5>0){
			      		  array_push($array, "<a style='*position:relative;*top:1px;' class=fy1 href=".ghref(1).">1...</a>");
			      		 }else{
			      			array_push($array, "<a style='*position:relative;*top:1px;' class=fy1 href=".ghref(1).">1</a>");	
			      		}
			      		for ($i = $this->page-3; $i <= $this->page+3; $i++) {
			          		array_push($array, "<a style='*position:relative;*top:1px;' class=fy".$i." href=".ghref($i).">$i</a>");
			      		 }
			      		 if(($this->page + 3<$this->page_count) && ($this->page+4<$this->page_count)){
				      		 array_push($array, "<a style='*position:relative;*top:1px;' class=fy".$this->page_count." href=".ghref($this->page_count).">...".$this->page_count."</a>");
				      	  }if(($this->page + 3<$this->page_count) && ($this->page+4==$this->page_count)){
				      		 array_push($array, "<a style='*position:relative;*top:1px;' class=fy".$this->page_count." href=".ghref($this->page_count).">".$this->page_count."</a>");
				      	  }
			      		 array_push($array, "<a href=".ghref($this->page_count).">末</a>");
			      	 }else{
			      	 		$array = array();
			      	 		array_push($array, "<a href=".ghref(1).">首</a>");
			      	 		if($this->page-5>0){
				      			array_push($array, "<a style='*position:relative;*top:1px;' class=fy1 href=".ghref(1).">1...</a>");
				      		}else{
				      			array_push($array, "<a style='*position:relative;*top:1px;' class=fy1 href=".ghref(1).">1</a>");	
				      		}
			      			for ($i = $this->page-3; $i <= $this->page_count; $i++) {				      			
				          	array_push($array, "<a style='*position:relative;*top:1px;' class=fy".$i." href=".ghref($i).">$i</a>");
			      		 }
			      		 array_push($array, "<a href=".ghref($this->page_count).">末</a>");
			      	}
		    		}
	    	}
	      return $array;
    }
    function listcon($sql)
    {
        $this->page = empty($_REQUEST['page']) ? 0 : $_REQUEST['page'];
        if ($this->page <= 0)
            $this->page = 1;
        if ($this->page >= $this->page_count)
            $this->page = $this->page_count;
        $offset = ($this->page - 1) * $this->page_size;
        $sql .= " limit " . $offset . "," . $this->page_size;
        return $sql;
    }
}
?>