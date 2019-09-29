<?php
// Store the theme path and theme name into the CONF and TMPL
$TMPL['theme_path'] = $CONF['theme_path'];
$TMPL['theme_name'] = $CONF['theme_name'] = $settings['theme'];
$TMPL['theme_url']  = $CONF['theme_url']  = $CONF['theme_path'] .'/' . $CONF['theme_name'];
