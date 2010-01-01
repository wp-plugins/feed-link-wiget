<?php

/*

Plugin Name: Feed Link Wiget
Description: Enables you to add your feed links to a widget area.
Plugin URI: http://dennishoppe.de/wordpress-plugins/feed-link-widget
Author: Dennis Hoppe
Author URI: http://dennishoppe.de
Version: 1.0

*/

If (!Class_Exists('wp_plugin_widget_feed_link')){
Class wp_plugin_widget_feed_link extends WP_Widget {
  var $base_url;
  var $text_domain;

  Function wp_plugin_widget_feed_link(){
    // Set Widget Settings
    $this->WP_Widget('feedlinker', 'Feed Link Widget');
    
    // Read base
    $this->base_url = get_option('home').'/'.Str_Replace("\\", '/', SubStr(  RealPath(DirName(__FILE__)), Strlen(ABSPATH) ));
    
    // Get ready to translate
    $this->Load_TextDomain();
    
    // Add hooks
    Add_Action ('wp_head', Array($this, 'IncludeCSS'));
    Add_Action ('widgets_init', Array ($this, 'Register'));
  }
  
  Function Register(){
    Register_Widget (get_class($this));
  }
  
  Function Load_TextDomain(){
    $this->text_domain = get_class($this);
    load_textdomain ($this->text_domain, DirName(__FILE__).'/language/'.get_locale().'.mo');
  }
  
  Function t ($text, $context = ''){
    // Translates the string $text with context $context
    If ($context == '')
      return __($text, $this->text_domain);
    Else
      return _x($text, $context, $this->text_domain);
  }

  Function IncludeCSS(){
    Echo '<link rel="stylesheet" type="text/css" href="'.$this->base_url.'/wp-plugin-widget-feed-link.css" />';
  }
  
  Function widget($args, $settings){
    Echo $args['before_widget'];
    Echo $args['before_title']; Echo $settings['title']; Echo $args['after_title'] ?>
    
    <ul class="wp_plugin_widget_feed_link">
      <?php If ($settings['article_rss']) : ?>
        <li class="rss"><a href="<?php bloginfo('rss2_url'); ?>" title="<?php Echo $this->t('Subscribe posts via RSS') ?>"><?php Echo $this->t('Subscribe posts via RSS') ?></a></li>
      <?php EndIf; ?>
      
      <?php If ($settings['article_atom']) : ?>
        <li class="atom"><a href="<?php bloginfo('atom_url'); ?>" title="<?php Echo $this->t('Subscribe posts via Atom') ?>"><?php Echo $this->t('Subscribe posts via Atom') ?></a></li>
      <?php EndIf; ?>
      
      <?php If ($settings['comments_rss']) : ?>
        <li class="rss"><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php Echo $this->t('Subscribe comments via RSS') ?>"><?php Echo $this->t('Subscribe comments via RSS') ?></a></li>
      <?php EndIf; ?>
      
      <?php If ($settings['comments_atom']) : ?>
        <li class="atom"><a href="<?php bloginfo('comments_atom_url'); ?>" title="<?php Echo $this->t('Subscribe comments via Atom') ?>"><?php Echo $this->t('Subscribe comments via Atom') ?></a></li>
      <?php EndIf; ?>

      <?php If ($settings['show_help']) : ?>
        <li class="help"><a href="<?php Echo $this->t('http://en.wikipedia.org/wiki/RSS') ?>" title="<?php Echo $this->t('What is that?') ?>"><?php Echo $this->t('What is that?') ?></a></li>
      <?php EndIf; ?>

    </ul>
    
    <?php Echo $args['after_widget'];
  }
  
  Function form($settings){
    // Form to configure the Widget in Admin panel
    Echo $this->t('Title:') ?> <input type="text" name="<?php Echo $this->get_field_name('title') ?>" value="<?php Echo $settings['title'] ?>" />
    <h3><?php Echo $this->t('Show subscribtion links:') ?></h3>
    <ul>
      <li><input type="checkbox" name="<?php Echo $this->get_field_name('article_rss') ?>" <?php checked($settings['article_rss'], 'on') ?> value="on" /><?php Echo $this->t('Posts via RSS') ?></li>
      <li><input type="checkbox" name="<?php Echo $this->get_field_name('article_atom') ?>" <?php checked($settings['article_atom'], 'on') ?> value="on" /><?php Echo $this->t('Posts via Atom') ?></li>
      <li><input type="checkbox" name="<?php Echo $this->get_field_name('comments_rss') ?>" <?php checked($settings['comments_rss'], 'on') ?> value="on" /><?php Echo $this->t('Comments via RSS') ?></li>
      <li><input type="checkbox" name="<?php Echo $this->get_field_name('comments_atom') ?>" <?php checked($settings['comments_atom'], 'on') ?> value="on" /><?php Echo $this->t('Comments via Atom') ?></li>
    </ul>
    <input type="checkbox" name="<?php Echo $this->get_field_name('show_help') ?>" <?php checked($settings['show_help'], 'on') ?> value="on"/><?php Echo $this->t('Show a help link.') ?><br />
    <?php
  }
  
  Function update($new_settings, $old_settings){
    // Save the $new_settings Array
    return $new_settings;
  }
} /* End of the Class */
New wp_plugin_widget_feed_link();
} /* End of the If-Class-Exists-Condition */
/* End of File */