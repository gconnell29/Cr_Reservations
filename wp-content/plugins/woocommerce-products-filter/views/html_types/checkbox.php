<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
$_REQUEST['additional_taxes'] = $additional_taxes;
$_REQUEST['hide_terms_count_txt'] = isset($this->settings['hide_terms_count_txt']) ? $this->settings['hide_terms_count_txt'] : 0;

if (!function_exists('woof_draw_checkbox_childs'))
{

    function woof_draw_checkbox_childs($taxonomy_info, $tax_slug, $childs, $show_count, $show_count_dynamic, $hide_dynamic_empty_pos)
    {
        $current_request = array();
        global $WOOF;
        $request = $WOOF->get_request_data();
        if ($WOOF->is_isset_in_request_data($tax_slug))
        {
            $current_request = $request[$tax_slug];
            $current_request = explode(',', urldecode($current_request));
        }
        //***
        static $hide_childs = -1;
        if ($hide_childs == -1)
        {
            $hide_childs = (int) get_option('woof_checkboxes_slide');
        }


        //excluding hidden terms
        $hidden_terms = array();
        if (isset($WOOF->settings['excluded_terms'][$tax_slug]))
        {
            $hidden_terms = explode(',', $WOOF->settings['excluded_terms'][$tax_slug]);
        }

        $childs = apply_filters('woof_sort_terms_before_out', $childs, 'checkbox');
        ?>
        <?php if (!empty($childs) AND is_array($childs)): ?>
            <ul class="woof_childs_list" <?php if ($hide_childs == 1): ?>style="display: none;"<?php endif; ?>>
                <?php foreach ($childs as $term) : $inique_id = uniqid(); ?>
                    <?php
                    $count_string = "";
                    $count = 0;
                    if (!in_array($term['slug'], $current_request))
                    {
                        if ($show_count)
                        {
                            if ($show_count_dynamic)
                            {
                                $count = $WOOF->dynamic_count($term, 2, $_REQUEST['additional_taxes']);
                            } else
                            {
                                $count = $term['count'];
                            }
                            $count_string = '<span class="woof_checkbox_count">(' . $count . ')</span>';
                        }
                        //+++
                        if ($hide_dynamic_empty_pos AND $count == 0)
                        {
                            continue;
                        }
                    }

                    if ($_REQUEST['hide_terms_count_txt'])
                    {
                        $count_string = "";
                    }

                    //excluding hidden terms
                    if (in_array($term['term_id'], $hidden_terms))
                    {
                        continue;
                    }
                    ?>
                <li <?php if ($WOOF->settings['dispay_in_row'][$tax_slug] AND empty($term['childs'])): ?>style="display: inline-block !important;"<?php endif; ?>><input type="checkbox" <?php if (!$count AND ! in_array($term['slug'], $current_request) AND $show_count): ?>disabled=""<?php endif; ?> id="<?php echo 'woof_' . $term['term_id'] . '_' . $inique_id ?>" class="woof_checkbox_term" data-tax="<?php echo $tax_slug ?>" name="<?php echo $term['slug'] ?>" value="<?php echo $term['term_id'] ?>" <?php echo checked(in_array($term['slug'], $current_request)) ?> /><label class="woof_checkbox_label" for="<?php echo 'woof_' . $term['term_id'] . '_' . $inique_id ?>" <?php if (checked(in_array($term['slug'], $current_request))): ?>style="font-weight: bold;"<?php endif; ?>><?php
                            if (has_filter('woof_before_term_name'))
                                echo apply_filters('woof_before_term_name', $term, $taxonomy_info);
                            else
                                echo $term['name'];
                            ?><?php echo $count_string ?></label>
                        <?php
                        if (!empty($term['childs']))
                        {
                            woof_draw_checkbox_childs($taxonomy_info, $tax_slug, $term['childs'], $show_count, $show_count_dynamic, $hide_dynamic_empty_pos);
                        }
                        ?>
                        <input type="hidden" value="<?php echo $term['name'] ?>" class="woof_n_<?php echo $tax_slug ?>_<?php echo $term['slug'] ?>" />

                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php
    }

}
?>
<ul class="woof_list woof_list_checkbox">
    <?php
    $woof_tax_values = array();
    $current_request = array();
    $request = $this->get_request_data();
    if ($this->is_isset_in_request_data($tax_slug))
    {
        $current_request = $request[$tax_slug];
        $current_request = explode(',', urldecode($current_request));
    }


    //excluding hidden terms
    $hidden_terms = array();
    if (isset($this->settings['excluded_terms'][$tax_slug]))
    {
        $hidden_terms = explode(',', $this->settings['excluded_terms'][$tax_slug]);
    }

    $terms = apply_filters('woof_sort_terms_before_out', $terms, 'checkbox');
    ?>
    <?php if (!empty($terms) AND is_array($terms)): ?>
        <?php foreach ($terms as $term) : $inique_id = uniqid(); ?>
            <?php
            $count_string = "";
            $count = 0;
            if (!in_array($term['slug'], $current_request))
            {
                if ($show_count)
                {
                    if ($show_count_dynamic)
                    {
                        $count = $this->dynamic_count($term, 2, $_REQUEST['additional_taxes']);
                    } else
                    {
                        $count = $term['count'];
                    }
                    $count_string = '<span class="woof_checkbox_count">(' . $count . ')</span>';
                }
                //+++
                if ($hide_dynamic_empty_pos AND $count == 0)
                {
                    continue;
                }
            }

            if ($_REQUEST['hide_terms_count_txt'])
            {
                $count_string = "";
            }

            //excluding hidden terms
            if (in_array($term['term_id'], $hidden_terms))
            {
                continue;
            }
            ?>
            <li <?php if ($this->settings['dispay_in_row'][$tax_slug] AND empty($term['childs'])): ?>style="display: inline-block !important;"<?php endif; ?>><input type="checkbox" <?php if (!$count AND ! in_array($term['slug'], $current_request) AND $show_count): ?>disabled=""<?php endif; ?> id="<?php echo 'woof_' . $term['term_id'] . '_' . $inique_id ?>" class="woof_checkbox_term" data-tax="<?php echo $tax_slug ?>" name="<?php echo $term['slug'] ?>" value="<?php echo $term['term_id'] ?>" <?php echo checked(in_array($term['slug'], $current_request)) ?> /><label class="woof_checkbox_label" for="<?php echo 'woof_' . $term['term_id'] . '_' . $inique_id ?>" <?php if (checked(in_array($term['slug'], $current_request))): ?>style="font-weight: bold;"<?php endif; ?>><?php
                    if (has_filter('woof_before_term_name'))
                        echo apply_filters('woof_before_term_name', $term, $taxonomy_info);
                    else
                        echo $term['name'];
                    ?><?php echo $count_string ?></label>
                <?php
                if (!empty($term['childs']))
                {
                    woof_draw_checkbox_childs($taxonomy_info, $tax_slug, $term['childs'], $show_count, $show_count_dynamic, $hide_dynamic_empty_pos);
                }
                ?>
                <input type="hidden" value="<?php echo $term['name'] ?>" class="woof_n_<?php echo $tax_slug ?>_<?php echo $term['slug'] ?>" />

            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
<?php
//we need it only here, and keep it in $_REQUEST for using in function for child items
unset($_REQUEST['additional_taxes']);
