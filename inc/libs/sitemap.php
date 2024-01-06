<?php
/**
 * @name Generador automatico de sitemap.xml
 * @author Miguel92
 * @copyright 25/11/2020 | 06/01/2024
*/

# Incluimos el header
include ("../../header.php");

# Obtenemos todas las categorías
$sql_c = db_exec(array(__FILE__, __LINE__), 'query', "SELECT * FROM p_categorias ORDER BY cid ASC");

# Obtenemos todos los posts
$sql_p = db_exec(array(__FILE__, __LINE__), 'query', "SELECT * FROM p_posts LEFT JOIN p_categorias ON cid = post_category WHERE post_status = 0 ORDER BY post_id DESC LIMIT 50");

# Obtenemos todos los usuarios
$sql_u = db_exec(array(__FILE__, __LINE__), 'query', "SELECT u.user_name, u.user_registro, p.p_nombre FROM u_miembros AS u LEFT JOIN u_perfil AS p ON u.user_id = p.user_id ORDER BY u.user_id DESC LIMIT 50");

$time = time();
header("Content-Type: text/xml"); 
echo'<?xml version="1.0" encoding="UTF-8"?>';
echo'<?xml-stylesheet type="text/xsl" href="'.$tsCore->settings['url'].'/inc/libs/sitemap.xsl?'.$time.'"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xhtml="http://www.w3.org/1999/xhtml" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
	<!-- Sitemap generado por Miguel92 en Syntaxis -->
	<?php while($rss = db_exec('fetch_array', $sql_u)){ ?>
		<url>
       	<loc><?php echo $tsCore->settings['url'];?>/perfil/<?php echo $rss['user_name'];?>/</loc>
       	<lastmod><?php echo $tsCore->timeseo($rss['user_registro'], true);?></lastmod>
       	<changefreq>daily</changefreq>
       	<priority>0.4096</priority>
  		</url>
	<?php } ?>
	<?php while($rss = db_exec('fetch_array', $sql_c)){ ?>
		<url>
       	<loc><?php echo $tsCore->settings['url'];?>/posts/<?php echo $rss['c_seo'];?>/</loc>
       	<lastmod><?php echo $tsCore->timeseo(time(), true);?></lastmod>
       	<changefreq>daily</changefreq>
       	<priority>0.4096</priority>
  		</url>
	<?php } ?>
	<?php while($rss = db_exec('fetch_array', $sql_p)){ ?>
		<url>
       	<loc><?php echo $tsCore->settings['url'];?>/posts/<?php echo $rss['c_seo'];?>/<?php echo $rss['post_id'];?>/<?php echo $tsCore->setSEO($rss['post_title']);?>.html</loc>
       	<lastmod><?php echo $tsCore->timeseo($rss['post_date'], true);?></lastmod>
       	<changefreq>daily</changefreq>
       	<priority>0.4096</priority>
  		</url>
	<?php } ?>
</urlset>
