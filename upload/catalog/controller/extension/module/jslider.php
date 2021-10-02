<?php
class ControllerExtensionModuleJslider extends Controller {
	public function index($setting) {
        static $module = 0;
		$this->load->language('extension/module/jslider');
		
		$data['heading_title'] = $this->language->get('heading_title');

        $this->load->model('design/banner');
        $this->load->model('tool/image');

//        $this->document->addStyle('catalog/view/javascript/jquery/swiper/css/swiper.min.css');
//        $this->document->addStyle('catalog/view/javascript/jquery/swiper/css/opencart.css');
//        $this->document->addScript('catalog/view/javascript/jquery/swiper/js/swiper.jquery.js');

        $data['banners'] = array();

        $results = $this->model_design_banner->getBanner($setting['banner_id']);

        foreach ($results as $result) {
            if (is_file(DIR_IMAGE . $result['image'])) {
                $data['banners'][] = array(
                    'title' => $result['title'],
                    'link'  => $result['link'],
//                    'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
                    'image' => $this->model_tool_image->resize($result['image'], 1400, 700)
                );
            }
        }

        $data['display_title'] = $setting['display_title'];
        $data['add_span'] = $setting['add_span'];
        $data['hclass'] = $setting['hclass'];
        $data['name'] = $setting['name'];

        switch ($setting['slmode']) {
            case '2':
                $data['slmode'] = 'horizontal';
                break;
            case '1':
                $data['slmode'] = 'vertical';
                break;
            case '0':
                $data['slmode'] = 'fade';
                break;
            default:
                $data['slmode'] = 'fade';
        }

        $data['valueR'] = $setting['valueR'];

        if(isset($setting['navi']) && $setting['navi'] == '1') {
            $data['navi'] = 'true';
        } else {
            $data['navi'] = 'false';
        }

        if(isset($setting['capt']) && $setting['capt'] == '1') {
            $data['capt'] = 'true';
        } else {
            $data['capt'] = 'false';
        }

        $data['module'] = $module++;

        $conf = $this->config->get('module_jslider');

        return $this->load->view('extension/module/jslider', $data);
	}}