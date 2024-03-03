<?php
/**
 * @name database.php
 * @author Miguel92
 * @copyright 2024
 */

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `f_comentarios` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `c_foto_id` int(11) NOT NULL DEFAULT 0,
  `c_user` int(11) NOT NULL DEFAULT 0,
  `c_date` int(10) NOT NULL DEFAULT 0,
  `c_body` text NOT NULL,
  `c_ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `f_fotos` (
  `foto_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_title` varchar(40) NOT NULL DEFAULT '',
  `f_date` int(10) NOT NULL DEFAULT 0,
  `f_description` text NOT NULL,
  `f_url` varchar(200) NOT NULL DEFAULT '',
  `f_user` int(11) NOT NULL DEFAULT 0,
  `f_closed` int(1) NOT NULL DEFAULT 0,
  `f_visitas` int(1) NOT NULL DEFAULT 0,
  `f_votos_pos` int(3) NOT NULL DEFAULT 0,
  `f_votos_neg` int(3) NOT NULL DEFAULT 0,
  `f_status` int(1) NOT NULL DEFAULT 0,
  `f_last` int(1) NOT NULL DEFAULT 0,
  `f_hits` int(11) NOT NULL DEFAULT 0,
  `f_ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`foto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `f_votos` (
  `vid` int(11) NOT NULL AUTO_INCREMENT,
  `v_foto_id` int(11) NOT NULL DEFAULT 0,
  `v_user` int(11) NOT NULL DEFAULT 0,
  `v_type` int(1) NOT NULL DEFAULT 0,
  `v_date` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `p_borradores` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `b_user` int(11) NOT NULL DEFAULT 0,
  `b_date` int(10) NOT NULL DEFAULT 0,
  `b_title` tinytext NOT NULL DEFAULT '',
  `b_body` text NOT NULL,
  `b_tags` varchar(128) DEFAULT NULL,
  `b_category` varchar(50) NOT NULL DEFAULT '',
  `b_private` int(1) NOT NULL DEFAULT 0,
  `b_block_comments` int(1) NOT NULL DEFAULT 0,
  `b_sponsored` int(1) NOT NULL DEFAULT 0,
  `b_sticky` int(1) NOT NULL DEFAULT 0,
  `b_smileys` int(1) NOT NULL DEFAULT 0,
  `b_visitantes` int(1) NOT NULL DEFAULT 0,
  `b_post_id` int(11) NOT NULL DEFAULT 0,
  `b_status` int(1) NOT NULL DEFAULT 1,
  `b_causa` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `p_categorias` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `c_orden` int(11) NOT NULL DEFAULT 0,
  `c_nombre` varchar(32) NOT NULL DEFAULT '',
  `c_seo` varchar(32) NOT NULL DEFAULT '',
  `c_img` varchar(32) NOT NULL DEFAULT 'comments.png',
  `c_iconify` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
INSERT INTO `p_categorias` (`cid`, `c_orden`, `c_nombre`, `c_seo`, `c_img`) VALUES
(1, 1, 'Animaciones', 'animaciones', 'flash.png'),
(2, 2, 'Apuntes y Monografías', 'apuntesymonografias', 'report.png'),
(3, 3, 'Arte', 'arte', 'palette.png'),
(4, 4, 'Autos y Motos', 'autosymotos', 'car.png'),
(5, 5, 'Celulares', 'celulares', 'phone.png'),
(6, 6, 'Ciencia y Educación', 'cienciayeducacion', 'lab.png'),
(7, 7, 'Comics', 'comics', 'comic.png'),
(8, 8, 'Deportes', 'deportes', 'sport.png'),
(9, 9, 'Downloads', 'downloads', 'disk.png'),
(10, 10, 'E-books y Tutoriales', 'ebooksytutoriales', 'ebook.png'),
(11, 11, 'Ecología', 'ecologia', 'nature.png'),
(12, 12, 'Economía y Negocios', 'economiaynegocios', 'economy.png'),
(13, 13, 'Femme', 'femme', 'female.png'),
(14, 14, 'Hazlo tu mismo', 'hazlotumismo', 'escuadra.png'),
(15, 15, 'Humor', 'humor', 'humor.png'),
(16, 16, 'Imágenes', 'imagenes', 'photo.png'),
(17, 17, 'Info', 'info', 'book.png'),
(18, 18, 'Juegos', 'juegos', 'controller.png'),
(19, 19, 'Links', 'links', 'link.png'),
(20, 20, 'Linux', 'linux', 'tux.png'),
(21, 21, 'Mac', 'mac', 'mac.png'),
(22, 22, 'Manga y Anime', 'mangayanime', 'manga.png'),
(23, 23, 'Mascotas', 'mascotas', 'pet.png'),
(24, 24, 'Música', 'musica', 'music.png'),
(25, 25, 'Noticias', 'noticias', 'newspaper.png'),
(26, 26, 'Off Topic', 'offtopic', 'comments.png'),
(27, 27, 'Recetas y Cocina', 'recetasycocina', 'cake.png'),
(28, 28, 'Salud y Bienestar', 'saludybienestar', 'heart.png'),
(29, 29, 'Solidaridad', 'solidaridad', 'salva.png'),
(30, 30, 'Syntaxis Lite', 'syntaxis-lite', 'tscript.png'),
(31, 31, 'Turismo', 'turismo', 'brujula.png'),
(32, 32, 'TV, Peliculas y series', 'tvpeliculasyseries', 'tv.png'),
(33, 33, 'Videos On-line', 'videosonline', 'film.png');";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `p_comentarios` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `c_post_id` int(11) NOT NULL DEFAULT 0,
  `c_user` int(11) NOT NULL DEFAULT 0,
  `c_date` int(10) NOT NULL DEFAULT 0,
  `c_body` text NOT NULL,
  `c_votos` int(3) NOT NULL DEFAULT 0,
  `c_status` int(1) NOT NULL DEFAULT  0,
  `c_ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `p_favoritos` (
  `fav_id` int(11) NOT NULL AUTO_INCREMENT,
  `fav_user` int(11) NOT NULL DEFAULT 0,
  `fav_post_id` int(11) NOT NULL DEFAULT 0,
  `fav_date` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`fav_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `p_posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_user` int(11) NOT NULL DEFAULT 0,
  `post_category` varchar(50) NOT NULL DEFAULT '',
  `post_title` tinytext NOT NULL DEFAULT '',
  `post_body` text NOT NULL,
  `post_date` int(10) NOT NULL DEFAULT 0,
  `post_tags` varchar(128) NOT NULL DEFAULT '',
  `post_puntos` int(11) unsigned NOT NULL DEFAULT 0,
  `post_comments` int(11) NOT NULL DEFAULT 0,
  `post_seguidores` int(11) NOT NULL DEFAULT 0,
  `post_shared` int(11) NOT NULL DEFAULT 0,
  `post_favoritos` int(11) NOT NULL DEFAULT 0,
  `post_cache` int(10) NOT NULL DEFAULT 0,
  `post_hits` int(11) NOT NULL DEFAULT 0,
  `post_ip` varchar(15) NOT NULL DEFAULT '',
  `post_private` int(1) NOT NULL DEFAULT 0,
  `post_block_comments` int(1) NOT NULL DEFAULT 0,
  `post_sponsored` int(1) NOT NULL DEFAULT 0,
  `post_sticky` int(1) NOT NULL DEFAULT 0,
  `post_smileys` int(1) NOT NULL DEFAULT 0,
  `post_visitantes` int(1) NOT NULL DEFAULT 0,
  `post_status` int(1) NOT NULL DEFAULT 0,
  `post_portada` tinytext NOT NULL DEFAULT '',
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "INSERT INTO `p_posts` (`post_id`, `post_user`, `post_category`, `post_title`, `post_body`, `post_tags`) VALUES (1, 1, 30, 'Bienvenido a Syntaxis Lite v3', '[align=center][size=18]Este es el primer post de los miles que tendrá tu web  ;) \r\n\r\nGracias por elegir a [url=https://www.phpost.es/]PHPost[/url] como tu Link Sharing System.[/size][/align]\r\n\r\n - Pasa a ser v3 porque el cambio ya no es compatible con v2.\r\n - Mucho más estructurado.\r\n - Mucho más limpio.\r\n - Se eliminó la configuración JSON, ya se almacenará en la base de datos.\r\n - Nuevo plugins para añadir fuentes de google\r\n - Actualización completa del plugins function.hook.php\r\n - Actualización completa del plugins function.jsdelivr.php\r\n - Actualización completa del plugins function.metadatos.php antes era function.meta.php\r\n\r\nCon la versión de [b]Syntaxis Lite v3[/b] actualizada: [ol][li]Smarty 4.3.x[/li][li]jQuery 3.7.x[/li][li]Plugins para jQuery actualizado y mejorado[/li][li]Modal modificado y con una nueva función[/li][li]Actualización al crear/editar post[/li][/ol]', 'Syntaxis, Lite, actualizado, smarty, php');";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `p_votos` (
  `voto_id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL DEFAULT 0,
  `tuser` int(11) NOT NULL DEFAULT 0,
  `cant` int(11) NOT NULL DEFAULT 0,
  `type` int(1) NOT NULL DEFAULT 1,
  `date` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`voto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_actividad` (
  `ac_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `obj_uno` int(11) NOT NULL DEFAULT 0,
  `obj_dos` int(11) NOT NULL DEFAULT 0,
  `ac_type` int(2) NOT NULL DEFAULT 0,
  `ac_date` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ac_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_avisos` (
  `av_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `av_subject` varchar(24) NOT NULL DEFAULT '',
  `av_body` text NOT NULL,
  `av_date` int(10) NOT NULL DEFAULT 0,
  `av_read` int(1) NOT NULL DEFAULT 0,
  `av_type` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`av_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_bloqueos` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `b_user` int(11) NOT NULL DEFAULT 0,
  `b_auser` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_follows` (
  `follow_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_user` int(11) NOT NULL DEFAULT 0,
  `f_id` int(11) NOT NULL DEFAULT 0,
  `f_type` int(1) NOT NULL DEFAULT 0,
  `f_date` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`follow_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_mensajes` (
  `mp_id` int(11) NOT NULL AUTO_INCREMENT,
  `mp_to` int(11) NOT NULL DEFAULT 0,
  `mp_from` int(11) NOT NULL DEFAULT 0,
  `mp_answer` int(1) NOT NULL DEFAULT 0,
  `mp_read_to` int(1) NOT NULL DEFAULT 0,
  `mp_read_from` int(1) NOT NULL DEFAULT 1,
  `mp_read_mon_to` int(1) NOT NULL DEFAULT 0,
  `mp_read_mon_from` int(1) NOT NULL DEFAULT 1,
  `mp_del_to` int(1) NOT NULL DEFAULT 0,
  `mp_del_from` int(1) NOT NULL DEFAULT 0,
  `mp_subject` varchar(50) NOT NULL DEFAULT '',
  `mp_preview` varchar(75) NOT NULL DEFAULT '',
  `mp_date` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`mp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_miembros` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(16) NOT NULL DEFAULT '',
  `user_password` varchar(66) NOT NULL DEFAULT '',
  `user_email` varchar(35) NOT NULL DEFAULT '',
  `user_rango` int(3) NOT NULL DEFAULT 3,
  `user_puntos` int(6) unsigned NOT NULL DEFAULT 0,
  `user_posts` int(11) NOT NULL DEFAULT 0,
  `user_comentarios` int(11) NOT NULL DEFAULT 0,
  `user_seguidores` int(11) NOT NULL DEFAULT 0,
  `user_seguidos` int(11) NOT NULL DEFAULT 0,
  `user_amigos` int(11) NOT NULL DEFAULT 0,
  `user_cache` int(10) NOT NULL DEFAULT 0,
  `user_puntosxdar` int(2) unsigned NOT NULL DEFAULT 0,
  `user_bad_hits` int(2) unsigned NOT NULL DEFAULT 0,
  `user_nextpuntos` int(10) NOT NULL DEFAULT 0,
  `user_registro` int(10) NOT NULL DEFAULT 0,
  `user_lastlogin` int(10) NOT NULL DEFAULT 0,
  `user_lastactive` int(10) NOT NULL DEFAULT 0,
  `user_lastpost` int(10) NOT NULL DEFAULT 0,
  `user_last_ip` varchar(15) NOT NULL DEFAULT 0,
  `user_name_changes` int(11) NOT NULL DEFAULT 3,
  `user_activo` int(1) NOT NULL DEFAULT 0,
  `user_baneado` int(1) NOT NULL DEFAULT 0,
  `user_verificado` int(1) NOT NULL DEFAULT 0,
  `user_twofactor` varchar(18) NOT NULL DEFAULT '',
  `user_socials` tinytext NOT NULL DEFAULT '{\"facebook\":false,\"google\":false}',
  `user_avatar` varchar(22) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_settings` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `setting_mode` enum('light', 'dark') NOT NULL DEFAULT 'light',
  `setting_attachment` int(1) NOT NULL DEFAULT 0, # Desactivado
  `setting_position` int(1) NOT NULL DEFAULT 7,
  `setting_repeat` int(1) NOT NULL DEFAULT 3,
  `setting_size` varchar(18) NOT NULL DEFAULT '',
  `setting_type` enum('pexels', 'unsplash') NOT NULL DEFAULT 'unsplash', 
  `setting_id` varchar(22) NOT NULL DEFAULT 'Wstln0400pE',
  `setting_width` int(4) NOT NULL DEFAULT 850,
  `setting_height` int(4) NOT NULL DEFAULT 315,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_nicks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `user_email` varchar(50) NOT NULL DEFAULT '',
  `name_1` varchar(15) NOT NULL DEFAULT '',
  `name_2` varchar(15) NOT NULL DEFAULT '',
  `hash` varchar(66) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `estado` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_monitor` (
  `not_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `obj_user` int(11) NOT NULL DEFAULT 0,
  `obj_uno` int(11) NOT NULL DEFAULT 0,
  `obj_dos` int(11) NOT NULL DEFAULT 0,
  `obj_tres` int(11) NOT NULL DEFAULT 0,
  `not_type` int(2) NOT NULL DEFAULT 0,
  `not_date` int(10) NOT NULL DEFAULT 0,
  `not_total` int(2) NOT NULL DEFAULT 1,
  `not_menubar` int(1) NOT NULL DEFAULT 2,
  `not_monitor` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`not_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_muro` (
  `pub_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_user` int(11) NOT NULL DEFAULT 0,
  `p_user_pub` int(11) NOT NULL DEFAULT 0,
  `p_date` int(10) NOT NULL DEFAULT 0,
  `p_comments` int(4) NOT NULL DEFAULT 0,
  `p_body` text NOT NULL,
  `p_likes` int(4) NOT NULL DEFAULT 0,
  `p_type` int(1) NOT NULL DEFAULT 0,
  `p_ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`pub_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_muro_adjuntos` (
  `adj_id` int(11) NOT NULL AUTO_INCREMENT,
  `pub_id` int(11) NOT NULL DEFAULT 0,
  `a_title` varchar(100) NOT NULL DEFAULT '',
  `a_url` text NOT NULL,
  `a_img` text NOT NULL,
  `a_desc` text NOT NULL,
  PRIMARY KEY (`adj_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_muro_comentarios` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `pub_id` int(11) NOT NULL DEFAULT 0,
  `c_user` int(11) NOT NULL DEFAULT 0,
  `c_date` int(10) NOT NULL DEFAULT 0,
  `c_body` text NOT NULL,
  `c_likes` int(4) NOT NULL DEFAULT 0,
  `c_ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_muro_likes` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `obj_id` int(11) NOT NULL DEFAULT 0,
  `obj_type` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`like_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_perfil` (
  `user_id` int(11) NOT NULL DEFAULT 0,
  `user_dia` int(2) NOT NULL DEFAULT 0,
  `user_mes` int(2) NOT NULL DEFAULT 0,
  `user_ano` int(4) NOT NULL DEFAULT 0,
  `user_pais` varchar(2) NOT NULL DEFAULT '',
  `user_estado` int(2) NOT NULL DEFAULT 1,
  `user_sexo` int(1) NOT NULL DEFAULT 1,
  `user_firma` text NOT NULL,
  `p_portada` TINYTEXT NOT NULL DEFAULT '',
  `p_nombre` varchar(32) NOT NULL DEFAULT '',
  `p_avatar` int(1) NOT NULL DEFAULT 0,
  `p_mensaje` varchar(60) NOT NULL DEFAULT '',
  `p_sitio` varchar(60) NOT NULL DEFAULT '',
  `p_socials` text NOT NULL DEFAULT 'a:5:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";}',
  `p_estado` int(1) NOT NULL DEFAULT 0,
  `p_estudios` int(1) NOT NULL DEFAULT 0,
  `p_profesion` varchar(32) NOT NULL DEFAULT '',
  `p_configs` varchar(100) NOT NULL DEFAULT 'a:3:{s:1:\"m\";s:1:\"5\";s:2:\"mf\";i:5;s:3:\"rmp\";s:1:\"5\";}',
  `p_total` varchar(54) NOT NULL DEFAULT 'a:6:{i:0;i:5;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;}',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_portal` (
  `user_id` int(11) NOT NULL DEFAULT 0,
  `last_posts_visited` text NOT NULL,
  `last_posts_shared` text NOT NULL,
  `last_posts_cats` text NOT NULL,
  `c_monitor` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_rangos` (
  `rango_id` int(3) NOT NULL AUTO_INCREMENT,
  `r_name` varchar(32) NOT NULL DEFAULT '',
  `r_color` varchar(6) NOT NULL DEFAULT 171717,
  `r_image` varchar(32) NOT NULL DEFAULT 'new.png',
  `r_cant` int(5) NOT NULL DEFAULT 0,
  `r_allows` varchar(1000) NOT NULL DEFAULT '',
  `r_type` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`rango_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;";

$syntaxis_lite[] = "
INSERT INTO `u_rangos` (`rango_id`, `r_name`, `r_color`, `r_image`, `r_cant`, `r_allows`, `r_type`) VALUES
(1, 'Administrador', 'D6030B', 'rosette.png', 0, 'a:4:{s:4:\"suad\";s:2:\"on\";s:4:\"goaf\";s:1:\"5\";s:5:\"gopfp\";s:2:\"20\";s:5:\"gopfd\";s:2:\"50\";}', 0),
(2, 'Moderador', 'ff9900', 'shield.png', 0, 'a:4:{s:4:\"sumo\";s:2:\"on\";s:4:\"goaf\";s:2:\"15\";s:5:\"gopfp\";s:2:\"18\";s:5:\"gopfd\";s:2:\"30\";}', 0),
(3, 'Novato', '9D9876', 'new.png', 0, 'a:12:{s:4:\"godp\";s:2:\"on\";s:4:\"gopp\";s:2:\"on\";s:5:\"gopcp\";s:2:\"on\";s:5:\"govpp\";s:2:\"on\";s:5:\"govpn\";s:2:\"on\";s:5:\"goepc\";s:2:\"on\";s:5:\"godpc\";s:2:\"on\";s:4:\"gopf\";s:2:\"on\";s:5:\"gopcf\";s:2:\"on\";s:4:\"goaf\";s:2:\"20\";s:5:\"gopfp\";s:1:\"5\";s:5:\"gopfd\";s:1:\"5\";}', 0),
(4, 'New Full User', '0198E7', 'star_bronze_3.png', 50, 'a:12:{s:4:\"godp\";s:2:\"on\";s:4:\"gopp\";s:2:\"on\";s:5:\"gopcp\";s:2:\"on\";s:5:\"govpp\";s:2:\"on\";s:5:\"govpn\";s:2:\"on\";s:5:\"goepc\";s:2:\"on\";s:5:\"godpc\";s:2:\"on\";s:4:\"gopf\";s:2:\"on\";s:5:\"gopcf\";s:2:\"on\";s:4:\"goaf\";s:2:\"20\";s:5:\"gopfp\";s:2:\"10\";s:5:\"gopfd\";s:2:\"10\";}', 1),
(5, 'Full User', '00ccff', 'star_silver_3.png', 70, 'a:12:{s:4:\"godp\";s:2:\"on\";s:4:\"gopp\";s:2:\"on\";s:5:\"gopcp\";s:2:\"on\";s:5:\"govpp\";s:2:\"on\";s:5:\"govpn\";s:2:\"on\";s:5:\"goepc\";s:2:\"on\";s:5:\"godpc\";s:2:\"on\";s:4:\"gopf\";s:2:\"on\";s:5:\"gopcf\";s:2:\"on\";s:4:\"goaf\";s:2:\"20\";s:5:\"gopfp\";s:2:\"12\";s:5:\"gopfd\";s:2:\"20\";}', 1),
(6, 'Great User', '01A021', 'star_gold_3.png', 0, 'a:12:{s:4:\"godp\";s:2:\"on\";s:4:\"gopp\";s:2:\"on\";s:5:\"gopcp\";s:2:\"on\";s:5:\"govpp\";s:2:\"on\";s:5:\"govpn\";s:2:\"on\";s:5:\"goepc\";s:2:\"on\";s:5:\"godpc\";s:2:\"on\";s:4:\"gopf\";s:2:\"on\";s:5:\"gopcf\";s:2:\"on\";s:4:\"goaf\";s:2:\"20\";s:5:\"gopfp\";s:2:\"11\";s:5:\"gopfd\";s:2:\"15\";}', 0),
(7, 'Gold User', 'cc6600', 'asterisk_yellow.png', 120, 'a:12:{s:4:\"godp\";s:2:\"on\";s:4:\"gopp\";s:2:\"on\";s:5:\"gopcp\";s:2:\"on\";s:5:\"govpp\";s:2:\"on\";s:5:\"govpn\";s:2:\"on\";s:5:\"goepc\";s:2:\"on\";s:5:\"godpc\";s:2:\"on\";s:4:\"gopf\";s:2:\"on\";s:5:\"gopcf\";s:2:\"on\";s:4:\"goaf\";s:2:\"20\";s:5:\"gopfp\";s:2:\"12\";s:5:\"gopfd\";s:2:\"25\";}', 1);";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_respuestas` (
  `mr_id` int(11) NOT NULL AUTO_INCREMENT,
  `mp_id` int(11) NOT NULL DEFAULT 0,
  `mr_from` int(11) NOT NULL DEFAULT 0,
  `mr_body` text NOT NULL,
  `mr_ip` varchar(15) NOT NULL DEFAULT '',
  `mr_date` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`mr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_sessions` (
  `session_id` varchar(32) NOT NULL DEFAULT '',
  `session_user_id` int(11) unsigned NOT NULL DEFAULT 0,
  `session_ip` varchar(40) NOT NULL DEFAULT '',
  `session_time` int(10) unsigned NOT NULL DEFAULT 0,
  `session_autologin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`session_id`),
  KEY `session_user_id` (`session_user_id`),
  KEY `session_time` (`session_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `u_suspension` (
  `susp_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `susp_causa` text NOT NULL,
  `susp_date` int(10) NOT NULL DEFAULT 0,
  `susp_termina` int(10) NOT NULL DEFAULT 0,
  `susp_mod` int(11) NOT NULL DEFAULT 0,
  `susp_ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`susp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `w_afiliados` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `a_titulo` varchar(35) NOT NULL DEFAULT '',
  `a_url` varchar(40) NOT NULL DEFAULT '',
  `a_banner` varchar(100) NOT NULL DEFAULT '',
  `a_descripcion` varchar(200) NOT NULL DEFAULT '',
  `a_sid` int(11) NOT NULL DEFAULT 0,
  `a_hits_in` int(11) NOT NULL DEFAULT 0,
  `a_hits_out` int(11) NOT NULL DEFAULT 0,
  `a_date` int(10) NOT NULL DEFAULT 0,
  `a_active` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `w_configuracion` (
  `tscript_id` int(11) NOT NULL DEFAULT 0,
  `titulo` varchar(24) NOT NULL DEFAULT '',
  `slogan` varchar(32) NOT NULL DEFAULT '',
  `url` tinytext NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `idioma` varchar(6) NOT NULL DEFAULT 'es-ES',
  `tema_id` int(11) NOT NULL DEFAULT 0,
  `c_allow_edad` int(11) NOT NULL DEFAULT 18,
  `c_allow_firma` int(1) NOT NULL DEFAULT 1,
  `c_allow_live` int(1) NOT NULL DEFAULT 1,
  `c_allow_points` int(11) NOT NULL DEFAULT 0,
  `c_allow_portal` int(1) NOT NULL DEFAULT 1,
  `c_allow_sess_ip` int(1) NOT NULL DEFAULT 1,
  `c_allow_sump` int(11) NOT NULL DEFAULT 0,
  `c_allow_upload` int(1) NOT NULL DEFAULT 0,
  `c_count_guests` int(1) NOT NULL DEFAULT 0,
  `c_desapprove_post` int(1) NOT NULL DEFAULT 0,
  `c_files_ext` varchar(150) NOT NULL DEFAULT '',
  `c_files_type` int(1) NOT NULL DEFAULT 0,
  `c_fotos_private` int(11) NOT NULL DEFAULT 0,
  `c_hits_guest` int(1) NOT NULL DEFAULT 0,
  `c_keep_points` int(1) NOT NULL DEFAULT 0,
  `c_last_active` int(2) NOT NULL DEFAULT 15,
  `c_max_acts` int(3) NOT NULL DEFAULT 99,
  `c_max_com` int(3) NOT NULL DEFAULT 50,
  `c_max_nots` int(3) NOT NULL DEFAULT 99,
  `c_max_posts` int(2) NOT NULL DEFAULT 50,
  `c_max_upload` int NOT NULL,
  `c_message_welcome` varchar(500) NOT NULL DEFAULT 'Hola [usuario], [welcome] a [b][web][/b].',
  `c_met_welcome` int(1) NOT NULL DEFAULT 0,
  `c_newr_type` int(11) NOT NULL DEFAULT 0,
  `c_reg_activate` int(1) NOT NULL DEFAULT 1,
  `c_reg_active` int(1) NOT NULL DEFAULT 1,
  `c_reg_rango` int(5) NOT NULL DEFAULT 3,
  `c_see_mod` int(1) NOT NULL DEFAULT 0,
  `c_stats_cache` int(7) NOT NULL DEFAULT 15,
  `offline_message` varchar(255) NOT NULL DEFAULT '',
  `offline` int(1) NOT NULL DEFAULT 0,
  `pkey` varchar(55) NOT NULL DEFAULT '',
  `skey` varchar(55) NOT NULL DEFAULT '',
  `version_code` varchar(22) NOT NULL DEFAULT '',
  `version` varchar(22) NOT NULL DEFAULT '',
  PRIMARY KEY (`tscript_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$syntaxis_lite[] = "INSERT INTO `w_configuracion` (`tscript_id`, `tema_id`) VALUES (1, 1);";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `w_settings` (
  `wid` int(11) NOT NULL DEFAULT 0,
  `setting_mode` enum('light', 'dark') NOT NULL DEFAULT 'light',
  `setting_attachment` int(1) NOT NULL DEFAULT 0, # Desactivado
  `setting_position` int(1) NOT NULL DEFAULT 0,
  `setting_repeat` int(1) NOT NULL DEFAULT 0,
  `setting_size` varchar(18) NOT NULL DEFAULT '',
  `setting_type` enum('pexels', 'unsplash') NOT NULL DEFAULT 'pexels', 
  `setting_id` varchar(22) NOT NULL DEFAULT '',
  `setting_width` int(4) NOT NULL DEFAULT 0,
  `setting_height` int(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "INSERT INTO w_settings (wid, setting_attachment, setting_position, setting_repeat, setting_size, setting_type, setting_id, setting_width, setting_height) VALUES (1, 0, 7, 3, 'cover', 'unsplash', 'jXd2FSvcRr8', 1200, 300);";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `w_seo` (
  `wid` int(11) NOT NULL DEFAULT 0,
  `seo_titulo` varchar(60) NOT NULL DEFAULT '',
  `seo_descripcion` text, 
  `seo_portada` tinytext NOT NULL,
  `seo_favicon` tinytext NOT NULL,
  `seo_imagenes` varchar(1000) NOT NULL DEFAULT '',
  `seo_robots` int(1) NOT NULL DEFAULT 0, 
  `seo_robots_name` int(1) NOT NULL DEFAULT 0,
  `seo_robots_content` int(1) NOT NULL DEFAULT 0,
  `seo_color` varchar(9) NOT NULL DEFAULT '',
  `seo_app_fb` varchar(20) NOT NULL DEFAULT '',
  `seo_tw_page` varchar(34) NOT NULL DEFAULT '',
  `seo_keywords` varchar(120) NOT NULL DEFAULT '',
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "INSERT INTO w_seo (wid, seo_titulo, seo_descripcion, seo_portada, seo_favicon, seo_imagenes, seo_robots, seo_robots_name, seo_robots_content, seo_color, seo_app_fb, seo_tw_page, seo_keywords) VALUES (1, 'Syntaxis Lite', 'Syntaxis Lite, es un sitio donde tu puedes encontrar todo, y puedes crear una cuenta gratis, nunca se te va a pedir un pago por ello!!!', '/public/assets/images/portada.png', '/public/assets/images/portada.png', 'a:3:{i:16;s:59:\"http://localhost/SyntaxisLite/files/SyntaxisLite-ico-16.png\";i:32;s:59:\"http://localhost/SyntaxisLite/files/SyntaxisLite-ico-32.png\";i:64;s:59:\"http://localhost/SyntaxisLite/files/SyntaxisLite-ico-64.png\";}', 1, 0, 0, '#212121', 234123465456783, '@SyntaxisLite2', 'web, juegos, blog, posts, videos, peliculas, series, offtopic, diferentes, titulos, aventura, accion, drama, comedia, estrategia');";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `w_ads` (
  `asd_id` int(11) NOT NULL DEFAULT 0,
  `banner` varchar(100) NOT NULL DEFAULT '',
  `ads_300` text NOT NULL,
  `ads_468` text NOT NULL,
  `ads_160` text NOT NULL,
  `ads_728` text NOT NULL,
  `ads_head` text NOT NULL,
  `ads_footer` text NOT NULL,
  `ads_search` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`asd_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$syntaxis_lite[] = "
INSERT INTO `w_ads` (`asd_id`, `banner`, `ads_300`, `ads_468`, `ads_160`, `ads_728`, `ads_head`, `ads_footer`, `ads_search`) VALUES
(1, 'Banner', 'ADS 300', 'ADS 468', 'ADS 160', 'ADS 728', 'ADS HEAD', 'ADS FOOTER', 'AD SEARCH');";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `w_denuncias` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `obj_id` int(11) NOT NULL DEFAULT 0,
  `d_user` int(11) NOT NULL DEFAULT 0,
  `d_razon` int(2) NOT NULL DEFAULT 0,
  `d_extra` text NOT NULL,
  `d_total` int(1) NOT NULL DEFAULT 1,
  `d_type` int(1) NOT NULL DEFAULT 0,
  `d_date` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`did`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `w_contacts` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL DEFAULT 0,
`user_email` varchar(50) NOT NULL DEFAULT '',
`time` int(15) NOT NULL DEFAULT 0,
`type` int(1) NOT NULL DEFAULT 0,
`hash` varchar(66) NOT NULL DEFAULT '',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `w_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_user` int(11) NOT NULL DEFAULT 0,
  `ticket_title` varchar(50) NOT NULL DEFAULT '',
  `ticket_body` text NOT NULL DEFAULT '',
  `ticket_type` int(11) NOT NULL DEFAULT 0,
  `ticket_status` int(1) NOT NULL DEFAULT 0,
  `ticket_date` int(15) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ticket_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `w_tickets_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_title` varchar(30) NOT NULL DEFAULT '',
  `type_icon` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "INSERT INTO `w_tickets_type` (`type_id`, `type_title`) VALUES 
(1, 'Posts'),(2, 'Fotos'),(3, 'Cuenta'),(4, 'Files'),(5, 'Comentarios'),(6, 'Avatar');";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `w_medallas` (
  `medal_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_autor` int(11) NOT NULL DEFAULT 0,
  `m_title` varchar(25) NOT NULL DEFAULT '',
  `m_description` varchar(120) NOT NULL DEFAULT '',
  `m_image` varchar(120) NOT NULL DEFAULT '',
  `m_cant` int(11) NOT NULL DEFAULT 0,
  `m_type` int(1) NOT NULL DEFAULT 0,
  `m_cond_user` int(11) NOT NULL DEFAULT 0,
  `m_cond_user_rango` int(11) NOT NULL DEFAULT 0,
  `m_cond_post` int(11) NOT NULL DEFAULT 0,
  `m_cond_foto` int(11) NOT NULL DEFAULT 0,
  `m_date` int(11) NOT NULL DEFAULT 0,
  `m_total` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`medal_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `w_medallas_assign` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`medal_id` int(11) NOT NULL DEFAULT 0,
`medal_for` int(11) NOT NULL DEFAULT 0,
`medal_date` int(11) NOT NULL DEFAULT 0,
`medal_ip` varchar(15) NOT NULL DEFAULT '',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `w_historial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pofid` int(11) NOT NULL DEFAULT 0,
  `type` int(1) NOT NULL DEFAULT 0,
  `action` int(1) NOT NULL DEFAULT 0,
  `mod` int(11) NOT NULL DEFAULT 0,
  `reason` text NOT NULL,
  `date` int(11) NOT NULL DEFAULT 0,
  `mod_ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `w_noticias` (
  `not_id` int(11) NOT NULL AUTO_INCREMENT,
  `not_body` text NOT NULL,
  `not_autor` INT( 11 ) NOT NULL,
  `not_date` int(10) NOT NULL DEFAULT 0,
  `not_active` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`not_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `w_blacklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL DEFAULT 0,
  `value` varchar(50) NOT NULL DEFAULT '',
  `reason` varchar(120) NOT NULL DEFAULT '',
  `author` int(11) NOT NULL DEFAULT 0,
  `date` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `w_badwords` (
  `wid` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(250) NOT NULL DEFAULT '',
  `swop` varchar(250) NOT NULL DEFAULT '',
  `method` int(1) NOT NULL DEFAULT 0,
  `type` int(1) NOT NULL DEFAULT 0,
  `author` int(11) NOT NULL DEFAULT 0,
  `reason` varchar(255) NOT NULL DEFAULT '',
  `date` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `w_stats` (
  `stats_no` int(1) NOT NULL DEFAULT 0,
  `stats_max_online` int(11) NOT NULL DEFAULT 0,
  `stats_max_time` int(10) NOT NULL DEFAULT 0,
  `stats_time` int(10) NOT NULL DEFAULT 0,
  `stats_time_cache` int(10) NOT NULL DEFAULT 0,
  `stats_time_foundation` int(11) NOT NULL DEFAULT 0,
  `stats_time_upgrade` int(11) NOT NULL DEFAULT 0,
  `stats_miembros` int(11) NOT NULL DEFAULT 0,
  `stats_posts` int(11) NOT NULL DEFAULT 0,
  `stats_fotos` int(11) NOT NULL DEFAULT 0,
  `stats_files` int(11) NOT NULL DEFAULT 0,
  `stats_comments` int(11) NOT NULL DEFAULT 0,
  `stats_foto_comments` int(11) NOT NULL DEFAULT 0,
  `stats_files_comments` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`stats_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$syntaxis_lite[] = "INSERT INTO `w_stats` (`stats_no`, `stats_max_online`) VALUES (1, 0);";

$syntaxis_lite[] = "
CREATE TABLE IF NOT EXISTS `w_temas` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `t_name` tinytext NOT NULL,
  `t_url` tinytext NOT NULL,
  `t_path` tinytext NOT NULL,
  `t_copy` tinytext NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `w_timezone` ( 
`zone_id` int(11) NOT NULL AUTO_INCREMENT, 
`zone_timezone` varchar(50) NOT NULL DEFAULT '',
PRIMARY KEY (`zone_id`),
  FULLTEXT `Zona` (`zone_timezone`)
) ENGINE=MyISAM CHARSET=utf8 COLLATE utf8_general_ci;";

$syntaxis_lite[] = "INSERT INTO `w_timezone` VALUES (NULL,'America/Adak'),(NULL,'America/Anchorage'),(NULL,'America/Anguilla'),(NULL,'America/Antigua'),(NULL,'America/Araguaina'),(NULL,'America/Argentina/Buenos_Aires'),(NULL,'America/Argentina/Catamarca'),(NULL,'America/Argentina/Cordoba'),(NULL,'America/Argentina/Jujuy'),(NULL,'America/Argentina/La_Rioja'),(NULL,'America/Argentina/Mendoza'),(NULL,'America/Argentina/Rio_Gallegos'),(NULL,'America/Argentina/Salta'),(NULL,'America/Argentina/San_Juan'),(NULL,'America/Argentina/San_Luis'),(NULL,'America/Argentina/Tucuman'),(NULL,'America/Argentina/Ushuaia'),(NULL,'America/Aruba'),(NULL,'America/Asuncion'),(NULL,'America/Atikokan'),(NULL,'America/Bahia'),(NULL,'America/Bahia_Banderas'),(NULL,'America/Barbados'),(NULL,'America/Belem'),(NULL,'America/Belize'),(NULL,'America/Blanc-Sablon'),(NULL,'America/Boa_Vista'),(NULL,'America/Bogota'),(NULL,'America/Boise'),(NULL,'America/Cambridge_Bay'),(NULL,'America/Campo_Grande'),(NULL,'America/Cancun'),(NULL,'America/Caracas'),(NULL,'America/Cayenne'),(NULL,'America/Cayman'),(NULL,'America/Chicago'),(NULL,'America/Chihuahua'),(NULL,'America/Costa_Rica'),(NULL,'America/Creston'),(NULL,'America/Cuiaba'),(NULL,'America/Curacao'),(NULL,'America/Danmarkshavn'),(NULL,'America/Dawson'),(NULL,'America/Dawson_Creek'),(NULL,'America/Denver'),(NULL,'America/Detroit'),(NULL,'America/Dominica'),(NULL,'America/Edmonton'),(NULL,'America/Eirunepe'),(NULL,'America/El_Salvador'),(NULL,'America/Fort_Nelson'),(NULL,'America/Fortaleza'),(NULL,'America/Glace_Bay'),(NULL,'America/Godthab'),(NULL,'America/Goose_Bay'),(NULL,'America/Grand_Turk'),(NULL,'America/Grenada'),(NULL,'America/Guadeloupe'),(NULL,'America/Guatemala'),(NULL,'America/Guayaquil'),(NULL,'America/Guyana'),(NULL,'America/Halifax'),(NULL,'America/Havana'),(NULL,'America/Hermosillo'),(NULL,'America/Indiana/Indianapolis'),(NULL,'America/Indiana/Knox'),(NULL,'America/Indiana/Marengo'),(NULL,'America/Indiana/Petersburg'),(NULL,'America/Indiana/Tell_City'),(NULL,'America/Indiana/Vevay'),(NULL,'America/Indiana/Vincennes'),(NULL,'America/Indiana/Winamac'),(NULL,'America/Inuvik'),(NULL,'America/Iqaluit'),(NULL,'America/Jamaica'),(NULL,'America/Juneau'),(NULL,'America/Kentucky/Louisville'),(NULL,'America/Kentucky/Monticello'),(NULL,'America/Kralendijk'),(NULL,'America/La_Paz'),(NULL,'America/Lima'),(NULL,'America/Los_Angeles'),(NULL,'America/Lower_Princes'),(NULL,'America/Maceio'),(NULL,'America/Managua'),(NULL,'America/Manaus'),(NULL,'America/Marigot'),(NULL,'America/Martinique'),(NULL,'America/Matamoros'),(NULL,'America/Mazatlan'),(NULL,'America/Menominee'),(NULL,'America/Merida'),(NULL,'America/Metlakatla'),(NULL,'America/Mexico_City'),(NULL,'America/Miquelon'),(NULL,'America/Moncton'),(NULL,'America/Monterrey'),(NULL,'America/Montevideo'),(NULL,'America/Montserrat'),(NULL,'America/Nassau'),(NULL,'America/New_York'),(NULL,'America/Nipigon'),(NULL,'America/Nome'),(NULL,'America/Noronha'),(NULL,'America/North_Dakota/Beulah'),(NULL,'America/North_Dakota/Center'),(NULL,'America/North_Dakota/New_Salem'),(NULL,'America/Ojinaga'),(NULL,'America/Panama'),(NULL,'America/Pangnirtung'),(NULL,'America/Paramaribo'),(NULL,'America/Phoenix'),(NULL,'America/Port-au-Prince'),(NULL,'America/Port_of_Spain'),(NULL,'America/Porto_Velho'),(NULL,'America/Puerto_Rico'),(NULL,'America/Punta_Arenas'),(NULL,'America/Rainy_River'),(NULL,'America/Rankin_Inlet'),(NULL,'America/Recife'),(NULL,'America/Regina'),(NULL,'America/Resolute'),(NULL,'America/Rio_Branco'),(NULL,'America/Santarem'),(NULL,'America/Santiago'),(NULL,'America/Santo_Domingo'),(NULL,'America/Sao_Paulo'),(NULL,'America/Scoresbysund'),(NULL,'America/Sitka'),(NULL,'America/St_Barthelemy'),(NULL,'America/St_Johns'),(NULL,'America/St_Kitts'),(NULL,'America/St_Lucia'),(NULL,'America/St_Thomas'),(NULL,'America/St_Vincent'),(NULL,'America/Swift_Current'),(NULL,'America/Tegucigalpa'),(NULL,'America/Thule'),(NULL,'America/Thunder_Bay'),(NULL,'America/Tijuana'),(NULL,'America/Toronto'),(NULL,'America/Tortola'),(NULL,'America/Vancouver'),(NULL,'America/Whitehorse'),(NULL,'America/Winnipeg'),(NULL,'America/Yakutat'),(NULL,'America/Yellowknife'),(NULL,'Europe/Amsterdam'),(NULL,'Europe/Andorra'),(NULL,'Europe/Astrakhan'),(NULL,'Europe/Athens'),(NULL,'Europe/Belgrade'),(NULL,'Europe/Berlin'),(NULL,'Europe/Bratislava'),(NULL,'Europe/Brussels'),(NULL,'Europe/Bucharest'),(NULL,'Europe/Budapest'),(NULL,'Europe/Busingen'),(NULL,'Europe/Chisinau'),(NULL,'Europe/Copenhagen'),(NULL,'Europe/Dublin'),(NULL,'Europe/Gibraltar'),(NULL,'Europe/Guernsey'),(NULL,'Europe/Helsinki'),(NULL,'Europe/Isle_of_Man'),(NULL,'Europe/Istanbul'),(NULL,'Europe/Jersey'),(NULL,'Europe/Kaliningrad'),(NULL,'Europe/Kiev'),(NULL,'Europe/Kirov'),(NULL,'Europe/Lisbon'),(NULL,'Europe/Ljubljana'),(NULL,'Europe/London'),(NULL,'Europe/Luxembourg'),(NULL,'Europe/Madrid'),(NULL,'Europe/Malta'),(NULL,'Europe/Mariehamn'),(NULL,'Europe/Minsk'),(NULL,'Europe/Monaco'),(NULL,'Europe/Moscow'),(NULL,'Europe/Oslo'),(NULL,'Europe/Paris'),(NULL,'Europe/Podgorica'),(NULL,'Europe/Prague'),(NULL,'Europe/Riga'),(NULL,'Europe/Rome'),(NULL,'Europe/Samara'),(NULL,'Europe/San_Marino'),(NULL,'Europe/Sarajevo'),(NULL,'Europe/Saratov'),(NULL,'Europe/Simferopol'),(NULL,'Europe/Skopje'),(NULL,'Europe/Sofia'),(NULL,'Europe/Stockholm'),(NULL,'Europe/Tallinn'),(NULL,'Europe/Tirane'),(NULL,'Europe/Ulyanovsk'),(NULL,'Europe/Uzhgorod'),(NULL,'Europe/Vaduz'),(NULL,'Europe/Vatican'),(NULL,'Europe/Vienna'),(NULL,'Europe/Vilnius'),(NULL,'Europe/Volgograd'),(NULL,'Europe/Warsaw'),(NULL,'Europe/Zagreb'),(NULL,'Europe/Zaporozhye'),(NULL,'Europe/Zurich');";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `files_comentarios` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_file` int(11) NOT NULL DEFAULT 0,
  `com_user` int(11) NOT NULL DEFAULT 0,
  `com_body` text NOT NULL,
  `com_date` int(10) NOT NULL DEFAULT 0,
  `com_status` int(1) NOT NULL DEFAULT 0,
  `com_ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`com_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `files_descargas` (
  `des_id` int(11) NOT NULL AUTO_INCREMENT,
  `des_file` int(11) NOT NULL DEFAULT 0,
  `des_user` int(11) NOT NULL DEFAULT 0,
  `des_author` int(11) NOT NULL DEFAULT 0,
  `des_total` int(11) NOT NULL DEFAULT 0,
  `des_date` int(10) NOT NULL DEFAULT 0,
  `des_ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`des_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `files_favoritos` (
  `fav_id` int(11) NOT NULL AUTO_INCREMENT,
  `fav_file` int(11) NOT NULL DEFAULT 0,
  `fav_user` int(11) NOT NULL DEFAULT 0,
  `fav_date` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`fav_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `files_archivos` (
  `arc_id` int(11) NOT NULL AUTO_INCREMENT,
  `arc_user` int(11) NOT NULL DEFAULT 0,
  `arc_name` varchar(50) NOT NULL DEFAULT '',
  `arc_code` tinytext NOT NULL DEFAULT '',
  `arc_weight` varchar(10) NOT NULL DEFAULT '',
  `arc_type` varchar(100) NOT NULL DEFAULT '',
  `arc_ext` varchar(10) NOT NULL DEFAULT '',
  `arc_downloads` int(11) NOT NULL DEFAULT 0,
  `arc_comments` int(11) NOT NULL DEFAULT 0,
  `arc_private` int(1) NOT NULL DEFAULT 0,
  `arc_status` int(1) NOT NULL DEFAULT 0,
  `arc_folder` int(11) NOT NULL DEFAULT 0,
  `arc_date` int(10) NOT NULL DEFAULT 0,
  `arc_ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`arc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `files_carpeta` (
  `car_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_user` int(11) NOT NULL DEFAULT 0,
  `car_name` tinytext NOT NULL DEFAULT '',
  `car_seo` tinytext NOT NULL DEFAULT '',
  `car_pass` tinytext NOT NULL DEFAULT '',
  `car_date` int(10) NOT NULL DEFAULT 0,
  `car_type` int(1) NOT NULL DEFAULT 0,
  `car_private` int(1) NOT NULL DEFAULT 0,
  `car_status` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`car_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `files_carpeta_tipos` (
  `ct_id` int(11) NOT NULL AUTO_INCREMENT,
  `ct_name` tinytext NOT NULL DEFAULT '',
  PRIMARY KEY (`ct_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

$syntaxis_lite[] = "INSERT INTO `files_carpeta_tipos` (`ct_id`, `ct_name`) VALUES (1, 'documentos'), (2, 'imagenes'), (3, 'musica'), (4, 'privada'), (5, 'protegido'), (6, 'publico'), (7, 'videos');";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `w_visitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL DEFAULT 0,
  `for` int(11) NOT NULL DEFAULT 0,
  `type` int(1) NOT NULL DEFAULT 0,
  `date` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `w_social` (
  `social_id` int(11) NOT NULL AUTO_INCREMENT,
  `social_name` varchar(22) NOT NULL DEFAULT '',
  `social_client_id` tinytext NULL,
  `social_client_secret` tinytext NULL,
  `social_redirect_uri` tinytext NULL,
  PRIMARY KEY (`social_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;";

$syntaxis_lite[] = "CREATE TABLE IF NOT EXISTS `u_miembros_social` (
  `social_id` int(11) NOT NULL AUTO_INCREMENT,
  `social_user_id` int(11) NOT NULL DEFAULT 0,
  `social_user_red` varchar(30) NOT NULL DEFAULT '',
  `social_user_name` varchar(60) NULL,
  `social_user_email` tinytext NULL,
  `social_user_avatar` tinytext NULL,
  PRIMARY KEY (`social_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;";