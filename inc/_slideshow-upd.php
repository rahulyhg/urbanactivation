    <link href="<?php echo $site_path;?>css/slideshow.css" rel="stylesheet" type="text/css" media="all" >

<script type="text/javascript" src="<?php echo $site_path;?>js/bootstrap-carousel.js"></script>
<script type="text/javascript" src="<?php echo $site_path;?>js/bootstrap-transition.js"></script>
<script type="text/javascript" src="<?php echo $site_path;?>js/bootstrap.js"></script>
 <script type="text/javascript" src="<?php echo $site_path;?>js/bootstrap-collapse.js"></script>

<script>
$(function() {
  
  $('.carousel').carousel();
  interval: 7000

});

</script>


<div id="carousel" class="carousel slide">
 <ol class="carousel-indicators">
<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
<li data-target="#myCarousel" data-slide-to="1"></li>
<li data-target="#myCarousel" data-slide-to="2"></li>
<li data-target="#myCarousel" data-slide-to="3"></li>
</ol>

  <div class="carousel-inner">

  <div class="item active">
       <a href="<?php echo $site_path;?>property"><img src="<?php echo $site_path;?>images/property.jpg" width="705" height="360"title="Click to view" alt="Click to view" ></a> 
       <div class="carousel-caption">
       <h4>Yarra House, South Yarra &#8211; One, two and three bedroom apartments</h4>
</div>
    </div>


      <div class="item">
 <a href="<?php echo $site_path;?>property"><img src="<?php echo $site_path;?>images/property.jpg" width="705" height="360"title="Click to view" alt="Click to view" ></a> 
 <div class="carousel-caption">
       <h4>Yarra House, South Yarra &#8211; One, two and three bedroom apartments</h4>
</div>
     </div>
     
      <div class="item">
 <a href="<?php echo $site_path;?>property"><img src="<?php echo $site_path;?>images/property.jpg" width="705" height="360"title="Click to view" alt="Click to view" ></a> 
 <div class="carousel-caption">
<h4>Yarra House, South Yarra &#8211; One, two and three bedroom apartments</h4>
</div>
    </div>
    
     <div class="item">
 <a href="<?php echo $site_path;?>property"><img src="<?php echo $site_path;?>images/property.jpg" width="705" height="360"title="Click to view" alt="Click to view" ></a> 
 <div class="carousel-caption">
       <h4>Yarra House, South Yarra &#8211; One, two and three bedroom apartments</h4>
</div>
    </div>
     
    
    </div>

<!-- <a class="carousel-control left" href="#carousel" data-slide="prev"></a>
  <a class="carousel-control right" href="#carousel" data-slide="next"></a>-->

</div>


