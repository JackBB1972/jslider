<?php
class ControllerExtensionModuleJslider extends Controller {
	public function index($setting) {
        static $module = 0;
		$this->load->language('extension/module/jslider');
		
		$data['heading_title'] = $this->language->get('heading_title');

        $this->load->model('design/banner');
        $this->load->model('tool/image');
        $this->load->model('extension/module/jslider');

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

        $result =  $this->model_extension_module_jslider->LoadSettings();
        $data['status ='] = $result['status'];
        $data['display_title'] = $result['display_title'];

        $data['module'] = $module++;

echo "<pre>";
var_dump($data);
echo "</pre>";

        return $this->load->view('extension/module/jslider', $data);
	}}