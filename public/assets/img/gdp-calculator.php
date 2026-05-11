<style>
    .div_center {
        width: 60%;
        margin: 0px auto
    }

    .form-bg {
        background-color: var(--newageForm);
        border-radius: 10px
    }

    .clr_blue {
        color: var(--left)
    }

    .br_overall {
        border: 2px solid #ddd;
    }

    .results_border {
        border-right: 2px solid #ddd;
    }


    .bdr-rad-10 {
        border-radius: 10px;
    }

    @media (max-width: 610px) {
        .div_center {
            width: 100%
        }

        .results_border {
            border-right: 0px
        }
    }
</style>
<?php error_reporting(0);
if (isset($_POST['submit'])) {
    $consumption = trim($_POST['consumption']);
    $consumption_unit = trim($_POST['consumption_unit']);
    $investment = trim($_POST['investment']);
    $investment_unit = trim($_POST['investment_unit']);
    $purchases = trim($_POST['purchases']);
    $purchases_unit = trim($_POST['purchases_unit']);
    $exports = trim($_POST['exports']);
    $exports_unit = trim($_POST['exports_unit']);
    $imports = trim($_POST['imports']);
    $imports_unit = trim($_POST['imports_unit']);
} elseif (isset($_GET['res_link'])) {
    $consumption = trim($_GET['consumption']);
    $consumption_unit = trim($_GET['consumption_unit']);
    $investment = trim($_GET['investment']);
    $investment_unit = trim($_GET['investment_unit']);
    $purchases = trim($_GET['purchases']);
    $purchases_unit = trim($_GET['purchases_unit']);
    $exports = trim($_GET['exports']);
    $exports_unit = trim($_GET['exports_unit']);
    $imports = trim($_GET['imports']);
    $imports_unit = trim($_GET['imports_unit']);
}
?>
<div class="container row pos_top">
    <div class="col m9 s12 padding_right_only padding_0_m">
        <form class="col s12 white z-depth-1 padding_b_10" action="<?= base_url($canonical) ?>" method="post">
            <div class="col l12 m12 s12 margin_zero center padding_5">
                <?php if (!isset($detail)) { ?>
                    <?php if ($this->session->flashdata('gdp_cl') != null) { ?>
                        <p class="red-text left-align font_s25"><b><?= $this->session->flashdata('gdp_cl') ?></b></p>
                    <?php } else { ?>
                        <img src="<?= base_url('assets/img/gdp-cal.' . $img_form) ?>" width="40" height="40" class="display_inline padding_5 m_b_n_10" alt="<?= $cal_name ?>">
                        <h1 class="color_blue left-align font_s25 display_inline"><b><?= $cal_name ?></b></h1>
                    <?php }
                } else { ?>
                    <div class="col m4 s4 left-align pdf_display padding_0">
                        <p class="color_blue font_s25"><b><?= $lang['res'] ?></b></p>
                    </div>
                    <div class="right pdf_display padding_0">
                        <img data-src="<?= base_url('assets/img/copy.' . $img_form) ?>" onclick="M.toast({html: 'Your Result is copied!', classes: 'rounded'})" id="copy" title="Copy Your Result!" alt="Copy" class="image res_icon hoverable">
                        <img data-src="<?= base_url('assets/img/save.' . $img_form) ?>" id="save" title="Download PDF" alt="pdf" class="res_icon image hoverable">
                        <img data-src="<?= base_url('assets/img/print.' . $img_form) ?>" id="print" title="Take a Print of Your Result" alt="print" class="hide-on-med-and-down image" width="24px" height="24px" style="margin:10px 10px 0px;cursor: pointer;">
                        <img data-src="<?= base_url('assets/img/share.' . $img_form) ?>" data-target="modal2" title="Share this Result" alt="share" class="res_icon image modal-trigger hoverable">
                        <img data-src="<?= base_url('assets/img/bookmark.' . $img_form) ?>" id="bookmark" title="Bookmark this Calculator" alt="bookmark" class="right res_icon image hoverable">
                    </div>
                    <div id="modal2" class="modal">
                        <div class="modal-content center">
                            <p class="padding_5 font_size20"><strong>Share via!</strong></p>
                            <img src="<?= base_url('assets/img/facebook.' . $img_form) ?>" class="res_icon" alt="fb" title="Share on Facebook" id="on_fb">
                            <img src="<?= base_url('assets/img/bird.' . $img_form) ?>" class="res_icon" alt="Share on facebook" title="Tw" id="on_twitter">
                            <img src="<?= base_url('assets/img/link.' . $img_form) ?>" class="res_icon" alt="Share on facebook" title="In" id="on_link">
                            <?php $uri_string = uri_string(); ?>
                            <input type="text" readonly id="copy_link" class="padding_5 border_1px m8 s12" value="<?= base_url($uri_string . '/?res_link=0&consumption=' . $consumption . '&consumption_unit=' . $consumption_unit . '&investment=' . $investment . '&investment_unit=' . $investment_unit . '&purchases=' . $purchases . '&purchases_unit=' . $purchases_unit . '&exports=' . $exports . '&exports_unit=' . $exports_unit . '&imports=' . $imports . '&imports_unit=' . $imports_unit) ?>">
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php if (!isset($detail)) { ?>
                <?php if (isset($lang['after_title'])) : ?>
                    <div class="col m10 s12 margin_top_10 padding_0 div_centere">
                        <p class="font_size16"><?= $lang['after_title']; ?></p>
                    </div>
                <?php endif; ?>
            <?php } ?>
            <?php if ($device == 'desktop' && $desktop_ad['after_name'] != 'off' && isset($desktop_ads['after_name'])) { ?>
                <div class="adds col s12 padding_5 center after_name"><?= $desktop_ads['after_name']; ?></div>
            <?php } ?>
            <?php if ($device == 'mobile' && $mobile_ad['mbl_after_name'] != 'off' && isset($mobile_ads['after_name'])) { ?>
                <div class="adds col s12 padding_5 center mbl_after_name"><?= $mobile_ads['after_name']; ?></div>
            <?php } ?>
            <?php if (!isset($detail)) { ?>
                <div class="col s1 hide-on-small-only"></div>
                <div class="col m10 s12 margin_top_10 border_form padding_20 padding_0_m">
                    <div class="col s12">
                        <div class="col m6 s12 padding_0">
                            <div class="input-field col s8 margin_zero">
                                <p class="padding_5"><?= $lang[1] ?>:</p>
                                <input type="number" step="any" name="consumption" value="<?= isset($consumption) ? $consumption : '10' ?>" class="validate">
                            </div>
                            <div class="col s4">
                                <p class="padding_5">&nbsp;</p>
                                <select class="browser-default" name="consumption_unit">
                                    <?php
                                    function optnsList($arr1, $arr2, $frst, $method)
                                    {
                                        foreach ($arr1 as $index => $name) {
                                    ?>
                                            <option value="<?php echo $name ?>" <?php if (isset($method)) {
                                                                                    echo $name === $method ? " selected" : "";
                                                                                } else {
                                                                                    echo $name === $frst ? " selected" : "";
                                                                                } ?>><?php echo $arr2[$index] ?></option>
                                    <?php
                                        }
                                    }
                                    $name = [$lang[6], $lang[7], $lang[8]];
                                    $val = [$lang[6], $lang[7], $lang[8]];
                                    optnsList($val, $name, $lang[6], $consumption_unit);
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col m6 s12 padding_0">
                            <div class="input-field col s8 margin_zero">
                                <p class="padding_5"><?= $lang[2] ?>:</p>
                                <input type="number" step="any" name="investment" value="<?= isset($investment) ? $investment : '8' ?>" class="validate">
                            </div>
                            <div class="col s4">
                                <p class="padding_5">&nbsp;</p>
                                <select class="browser-default" name="investment_unit">
                                    <?php
                                    $name = [$lang[6], $lang[7], $lang[8]];
                                    $val = [$lang[6], $lang[7], $lang[8]];
                                    optnsList($val, $name, $lang[6], $investment_unit);
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="col m6 s12 padding_0">
                            <div class="input-field col s8 margin_zero">
                                <p class="padding_5"><?= $lang[3] ?>:</p>
                                <input type="number" step="any" name="purchases" value="<?= isset($purchases) ? $purchases : '6' ?>" class="validate">
                            </div>

                            <div class="col s4">
                                <p class="padding_5">&nbsp;</p>
                                <select class="browser-default" name="purchases_unit">
                                    <?php
                                    $name = [$lang[6], $lang[7], $lang[8]];
                                    $val = [$lang[6], $lang[7], $lang[8]];
                                    optnsList($val, $name, $lang[6], $purchases_unit);
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col m6 s12 padding_0">
                            <div class="input-field col s8 margin_zero">
                                <p class="padding_5"><?= $lang[4] ?>:</p>
                                <input type="number" step="any" name="exports" value="<?= isset($exports) ? $exports : '4' ?>" class="validate">
                            </div>
                            <div class="col s4">
                                <p class="padding_5">&nbsp;</p>
                                <select class="browser-default" name="exports_unit">
                                    <?php
                                    $name = [$lang[6], $lang[7], $lang[8]];
                                    $val = [$lang[6], $lang[7], $lang[8]];
                                    optnsList($val, $name, $lang[6], $exports_unit);
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="col m6 s12 padding_0">
                            <div class="input-field col s8 margin_zero">
                                <p class="padding_5"><?= $lang[5] ?>:</p>
                                <input type="number" step="any" name="imports" value="<?= isset($imports) ? $imports : '2' ?>" class="validate">
                            </div>
                            <div class="col s4">
                                <p class="padding_5">&nbsp;</p>
                                <select class="browser-default" name="imports_unit">
                                    <?php
                                    $name = [$lang[6], $lang[7], $lang[8]];
                                    $val = [$lang[6], $lang[7], $lang[8]];
                                    optnsList($val, $name, $lang[6], $imports_unit);
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s1 hide-on-small-only"></div>
                <?php if ($device == 'desktop' && $desktop_ad['before_btn'] != 'off' && isset($desktop_ads['before_btn'])) { ?>
                    <div class="adds col s12 margin_top_15 center before_btn"><?= $desktop_ads['before_btn']; ?></div>
                <?php } ?>
                <?php if ($device == 'mobile' && $mobile_ad['mbl_before_btn'] != 'off' && isset($mobile_ads['before_btn'])) { ?>
                    <div class="adds col s12 padding_5 center mbl_before_btn"><?= $mobile_ads['before_btn']; ?></div>
                <?php } ?>
                <div class="input-field col s12 center margin_zero">
                    <button type="submit" name="submit" class="white-text btn-small border_radius_50 waves-effect waves-light margin_top_10"><?= $lang['calculate'] ?></button>
                </div>
            <?php } else { ?>
                <div class="col s12 padding_0 result canvas_div_pdf font_size18" id="printThis">
                    <div class="pdf_logo col s12 padding_0"></div>
                    <div class="col s12 padding_0_m">
                        <div id="res_copy">

                            <div class="col s12 padding_20 padding_10_mbl form-bg">
                                <div class="col m6 s12 padding_0  results_border">
                                    <p class="font_size18"><strong>GDP</strong></p>
                                    <p class="clr_blue font_size30">
                                        <b>
                                            <?= round($detail['gdp'], 4) ?></b>
                                    </p>
                                </div>
                                <div class="col m6 s12 padding_left_only padding_0_m">
                                    <p class="font_size18"><strong><?= $lang[9] ?></strong></p>
                                    <p class="clr_blue">
                                        <b class="font_size28">
                                            <?= round($detail['net_export'], 4) ?></b>
                                    </p>
                                </div>
                            </div>

                            <div class="col s12 padding_20 br_overall bdr-rad-10 margin_top_20 ">
                                <p class="font_s25 color_blue"><strong><?= $lang[10] ?></strong></p>
                                <p class="margin_top_10 font_size16"><?= $lang[11] ?>.</p>
                                <p class="margin_top_10 font_size16">GDP = <?= $lang[1] ?> + <?= $lang[2] ?> + <?= $lang[3] ?> + <?= $lang[9] ?></p>
                                <p class="margin_top_10 font_size16"><?= $lang[12] ?>.</p>
                                <p class="margin_top_10 font_size16"><?= $lang[9] ?> = <?= $lang[4] ?> - <?= $lang[5] ?></p>
                                <p class="margin_top_10 font_size16"><?= $lang[9] ?> = <?php echo $exports; ?> - <?php echo $imports ?></p>
                                <p class="margin_top_10 font_size16"><?= $lang[9] ?> = <?= round($detail['net_export'], 4) ?></p>
                                <p class="margin_top_10 font_size16"><?= $lang[13] ?>:</p>
                                <p class="margin_top_10 font_size16">GDP = <?php echo $consumption; ?> + <?php echo $investment; ?> + <?php echo $purchases; ?> + <?= round($detail['net_export'], 4) ?></p>

                                <p class="margin_top_10 font_size16">GDP = <?= round($detail['gdp'], 4) ?></p>
                            </div>
                        </div>
                    </div>
                    <p class="col s12 display_none font_size20 pdf_repot center-align">This report is generated by <a href="<?= base_url(); ?>" class="color_blue">thetime-calculator.com</a></p>
                </div>
                <?php if ($device == 'desktop' && $desktop_ad['before_btn'] != 'off' && isset($desktop_ads['before_btn'])) { ?>
                    <div class="adds col s12 margin_top_15 center before_btn"><?= $desktop_ads['before_btn']; ?></div>
                <?php } ?>
                <?php if ($device == 'mobile' && $mobile_ad['mbl_before_btn'] != 'off' && isset($mobile_ads['before_btn'])) { ?>
                    <div class="adds col s12 padding_5 center mbl_before_btn"><?= $mobile_ads['before_btn']; ?></div>
                <?php } ?>
                <div class="input-field col s12 center margin_zero">
                    <button type="submit" name="reset" class="white-text btn-small border_radius_50 waves-effect waves-light margin_top_10"><?= $lang['reset'] ?></button>
                </div>
            <?php } ?>
            <?php if ($device == 'mobile') { ?>
                <div class="col s12">
                    <a class="modal-trigger col s12 right-align" href="#modal1">Report a Problem</a>
                    <div class="col s12 center padding_b_10">
                        <p class="col s12 padding_10">Share this Calculator on Social Media</p>
                        <img data-src="<?= base_url('assets/img/fb_.' . $img_form) ?>" width="35" height="35" class="facebook image" alt="Fb" title="Share this page on Facebook">
                        <img data-src="<?= base_url('assets/img/twitter_.' . $img_form) ?>" width="35" height="35" class="twitter image" alt="tw" title="Share this page on Twitter">
                        <img data-src="<?= base_url('assets/img/linkedin_.' . $img_form) ?>" width="35" height="35" class="linkin image" alt="In" title="Share this page on LinkedIn">
                        <img data-src="<?= base_url('assets/img/whatsapp_.' . $img_form) ?>" width="35" height="35" class="whatsapp image" alt="wa" title="Share this page on Whatsapp">
                    </div>
                </div>
            <?php } ?>
        </form>
        <?php if ($device == 'desktop' && $desktop_ad['after_btn'] != 'off' && isset($desktop_ads['after_btn'])) { ?>
            <div class="adds col s12 center margin_top_15 after_btn"><?= $desktop_ads['after_btn']; ?></div>
        <?php } ?>
        <?php if ($device == 'mobile' && $mobile_ad['mbl_after_btn'] != 'off' && isset($mobile_ads['after_btn'])) { ?>
            <div class="adds col s12 center margin_top_10 mbl_after_btn"><?= $mobile_ads['after_btn']; ?></div>
        <?php } ?>
        <?php if ($device == 'mobile') { ?>
            <div class="col s12 related show-on-small">
                <?php if (isset($related)) { ?>
                    <div class="col s12 margin_top_20">
                        <strong class="col s12 font_size20 color_blue"><?= $lang['related_cal'] ?> <font color="#4e342e"><?= $lang['calculator'] ?></font></strong>
                        <hr class="col widget_line related_line">
                        <?php include 'mbl_related.php'; ?>
                    </div>
                    <?php if ($device == 'mobile' && $mobile_ad['mbl_after_rel'] != 'off' && isset($mobile_ads['after_rel'])) { ?>
                        <div class="adds col s12 padding_5 margin_top_20 center mbl_after_rel"><?= $mobile_ads['after_rel']; ?></div>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
        <?php
        $currentURI = uri_string();
        $currentURI = explode('/', $currentURI);
        if (count($currentURI) == 1) { ?>
            <div class="col s12 margin_top_20 white z-depth-1 border_radius_5 padding_b_20">
                <p class="col s12 font_size20 margin_top_10"><strong class="new_line">Table of Content</strong></p>
                <div class="col m7 s12 font_size16 padding_10">
                    <table class="highlight">

                    </table>
                </div>
                <div class="col m5 s12 padding_lr20_10">
                    <div class="col m11 s12 white z-depth-1 border_radius_5 padding_10 right margin_t_10_m">
                        <p class="col s12 font_size20"><strong class="new_line">Get the Widget!</strong></p>
                        <p class="col s12 margin_top_10">Add this calculator to your site and lets users to perform easy calculations. </p>
                        <div class="center col s12 margin_top_10">
                            <a class="waves-effect waves-light btn-small bg_blue center margin_zero border_radius_50" style="width: 140px" href="<?= base_url($page . '/get-widget/') ?>" title="Get Code"><?= $lang['get_code'] ?></a>
                        </div>
                    </div>
                    <div class="col m11 s12 white z-depth-1 border_radius_5 padding_10 margin_top_20 right">
                        <p class="col s12 font_size20"><strong class="new_line">Feedback</strong></p>
                        <p class="col s12 margin_top_10">How easy was it to use our calculator? Did you face any problem, tell us!</p>
                        <div class="center col s12 margin_top_10">
                            <a class="waves-effect waves-light btn-small center margin_zero border_radius_50 modal-trigger " style="width: 140px;background: #000 !important;" href="#modal1" title="Feedback">FEEDBACK</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="col m6 s12 margin_top_10 padding_right_only padding_10_m">
                <div class="col s12 white z-depth-1 padding_b_10">
                    <strong class="col s12 font_size20 color_blue"><?= $lang['get'] ?> <font color="#4e342e"><?= $lang['widget'] ?></font></strong>
                    <hr class="col widget_line related_line">
                    <p class="col s12 font_size16 margin_top_10"><?= $lang['add_site'] ?></p>
                    <P class="col s12 margin_top_10"><?= $lang['widget_content'] ?></P>
                    <div class="center col s12">
                        <a class="waves-effect waves-light btn-small center margin_zero margin_top_10 border_radius_50" style="width: 140px" href="<?= base_url($page . '/get-widget/') ?>" title="Get Code"><?= $lang['get_code'] ?></a>
                    </div>
                </div>
            </div>
            <div class="col m6 s12 margin_top_10 padding_left_only hide-on-small-only">
                <div class="col s12 white z-depth-1 padding_b_10 margin_0_m">
                    <strong class="col s12 font_size20 color_blue"><?= $lang['ave'] ?> <font color="#4e342e"><?= $lang['on'] ?></font></strong>
                    <hr class="col widget_line related_line">
                    <p class="col s12 margin_top_10"><?= $lang['app_note'] ?></p>
                    <div class="center col s12 margin_top_20">
                        <a><img data-src="<?= base_url('assets/img/google_play.' . $img_form) ?>" class="image" height="39" width="125" alt="app"></a>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($device == 'desktop' && $desktop_ad['after_widget'] != 'off' && isset($desktop_ads['after_widget'])) { ?>
            <div class="adds col s12 padding_5 center margin_top_15 after_widget"><?= $desktop_ads['after_widget']; ?></div>
        <?php } ?>
        <div class="col s12 content white border_1px padding_20 margin_top_10 ">
            <div class="col s12">
                <?php $this->load->helper('content'); ?>
            </div>
        </div>
    </div>
    <?php
    if ($device == 'desktop') {
        require 'sidebar.php';
    }
    ?>
</div>
<?php if ($device == 'desktop' && $desktop_ad['end'] != 'off' && isset($desktop_ads['page_end'])) { ?>
    <div class="adds col s12 padding_5 center page_end">
        <?= $desktop_ads['page_end']; ?>
    </div>
<?php } ?>
<?php if ($device == 'mobile' && $mobile_ad['mbl_end'] != 'off' && isset($mobile_ads['page_end'])) { ?>
    <div class="adds col s12 padding_5 center mbl_end">
        <?= $mobile_ads['page_end']; ?>
    </div>
<?php } ?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<?php if (isset($detail)) { ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<?php } ?>
<script>
    <?php if (isset($detail)) { ?>

        function getPDF() {
            var a = $(".canvas_div_pdf").width(),
                s = $(".canvas_div_pdf").height(),
                d = a + 10,
                l = 1.5 * d + 10,
                e = a,
                n = s,
                c = Math.ceil(s / l) - 1;
            html2canvas($(".canvas_div_pdf")[0], {
                allowTaint: !0
            }).then(function(a) {
                a.getContext("2d");
                var s = a.toDataURL("image/jpeg", 1),
                    i = new jsPDF("p", "pt", [d, l]);
                i.addImage(s, "JPG", 5, 5, e, n);
                for (var o = 1; o <= c; o++) i.addPage(d, l), i.addImage(s, "JPG", 5, -l * o + 20, e, n);
                i.save("<?= $cal_name ?> Result by thetime-calculator.com.pdf")
            })
        }
        $("#save").click(function() {
            $(".pdf_display").css("display", "none");
            $(".pdf_logo").append('<div class="col l3 s6 jdf_display_none"><img src="<?= base_url("assets/img/logo1.png") ?>" class="col s12"></div>'), $(".pdf_repot").css("display", "block"), getPDF(), $(".jdf_display_none").css("display", "none"), $(".pdf_display").css("display", "block"), $(".pdf_repot").css("display", "none")
        });
    <?php } ?>
    $(document).ready(function() {
        'use strict';

        function copyElementText(id) {
            var text = document.getElementById(id).innerText;
            var elem = document.createElement("textarea");
            document.body.appendChild(elem);
            elem.value = text;
            elem.select();
            document.execCommand("copy");
            document.body.removeChild(elem);
        }
        $('#copy').click(function() {
            copyElementText('res_copy');
        });
        $('#bookmark').click(function() {
            alert('Press Ctrl+D to bookmark this calculator.')
        });
        $('#on_fb').click(function() {
            var url = $('#copy_link').val();
            url = encodeURIComponent(url);
            url = "https://www.facebook.com/sharer/sharer.php?u=" + url;
            WindowCenter(url, "Share Result on Facebook", "600", "500");
        });
        $('#on_twitter').click(function() {
            var url = $('#copy_link').val();
            url = encodeURIComponent(url);
            url = "https://twitter.com/intent/tweet?url=" + url;
            WindowCenter(url, "Share Result on Twitter", "600", "500");
        });
        $('#on_link').click(function() {
            var url = $('#copy_link').val();
            url += "&title=<?= $page_title ?>";
            url = encodeURIComponent(url);
            url = "https://www.linkedin.com/shareArticle?mini=true&url=" + url;
            WindowCenter(url, "Share Result on Twitter", "600", "500");
        });
        $('#on_mail').click(function() {
            var text = "<?= $lang['9'] ?>: " + $('#mad').text() + "%0A" +
                "<?= base_url($uri_string . '/') ?>";
            var url = "mailto:?subject=<?= $cal_name ?> Result by thetime-calculator.com&body=" + text;
            document.location.href = url;
        });
        $('#copy_link').click(function() {
            $('#copy_link').select();
            document.execCommand('copy');
        });
        <?php if ($device == 'desktop') { ?>
            var distance = $('.sticky_ad').offset().top,
                $window = $(window);
            $window.scroll(function() {
                if ($window.scrollTop() >= distance) {
                    $('.sticky_ad').addClass('fixed_ad');
                } else {
                    $('.sticky_ad').removeClass('fixed_ad');
                }
            });
            $(window).scroll(function() {
                if ($(window).scrollTop() >= $(document).height() - $(window).height() - 200) {
                    $('.sticky_ad').removeClass('fixed_ad');
                }
            });
        <?php } ?>
    });
</script>