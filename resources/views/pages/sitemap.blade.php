<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:xhtml="http://www.w3.org/1999/xhtml">';
?>

  <url>
    <loc>https://thetime-calculator.com/health/</loc>
  </url>
  <url>
    <loc>https://thetime-calculator.com/math/</loc>
  </url>
  <url>
    <loc>https://thetime-calculator.com/finance/</loc>
  </url>
  <url>
    <loc>https://thetime-calculator.com/everyday-life/</loc>
  </url>
  <url>
    <loc>https://thetime-calculator.com/physics/</loc>
  </url>
  <url>
    <loc>https://thetime-calculator.com/chemistry/</loc>
  </url>
  <url>
    <loc>https://thetime-calculator.com/statistics/</loc>
  </url>
  <url>
    <loc>https://thetime-calculator.com/construction/</loc>
  </url> 
  <url>
    <loc>https://thetime-calculator.com/pets/</loc>
  </url> 
<url>
    <loc>https://thetime-calculator.com/timedate/</loc>
  </url>
<url>
    <loc>https://thetime-calculator.com/contact-us/</loc>
  </url>
<url>
    <loc>https://thetime-calculator.com/about-us/</loc>
  </url>
<url>
    <loc>https://thetime-calculator.com/terms-of-service/</loc>
  </url>
<url>
    <loc>https://thetime-calculator.com/privacy-policy/</loc>
</url>
<url>
    <loc>https://thetime-calculator.com/content-disclaimer/</loc>
</url>
<url>
  <loc>https://thetime-calculator.com/editorial-Policies/</loc>
</url>
<url>
  <loc>https://thetime-calculator.com/feedback/</loc>
</url>

<url>
  <loc>https://thetime-calculator.com/blog/</loc>
</url>

<?php
    if (isset($posts)){
     
        foreach ($posts as $value) 
        {
            $check=explode('/',$value->post_url);
            if (count($check)==1 && $value->knowledge==0) {
echo "
<url>".
  "
  <loc>".url('blog/'.$value->post_url)."/</loc>
  ";
echo "</url>";
            }else{
               
              $category = strtolower($value->post_cat);
                
echo "<url>".
  "
  <loc>".url($category.'/'.$value->post_url)."/</loc>
  ";
echo "</url>";
            }
        }
    }

    
    if (isset($calculators)){
     
        foreach ($calculators as $value) 
        {
            $check=explode('/',$value->cal_link);
            if (count($check)==1) {
echo "
<url>".
  "
  <loc>".url($value->cal_link)."/</loc>
  ";
echo "</url>";
            }
        }
    }

echo "</urlset>";


?>