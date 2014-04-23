<?php
class AutoController extends Zend_Controller_Action{
	public function init() {
		 
	}
	public function updateindexingAction(){
		$objSeopage 	= new HT_Model_administrator_models_seopage();
		$objSeopage->updateIndexing();
	}
	public function automarkAction(){
		$objSeopage 				= new HT_Model_administrator_models_seopage();
		$totalMark					= $objSeopage->autoMark(200);
		echo $totalMark; die();
	}

	public function autolinkAction(){
		$objSeopage 				= new HT_Model_administrator_models_seopage();
		$totalLinked				= $objSeopage->autoLinkContent(1000);
		echo $totalLinked; die();
	}

	public function sitemapAction(){
		$objUtil 					= new HT_Model_administrator_models_utility();
		$sitemapData 				= $this->buildXMLSitemap();
		$filePath					= ROOT_PATH.'/public/sitemap/sitemap.xml';
		$objUtil->overWriteFile($filePath,$sitemapData);
		echo 'done!';die();
	}

	public function buildXMLSitemap(){
		$objSeogroup 	= new HT_Model_administrator_models_seogroup();
		$objSeopage 	= new HT_Model_administrator_models_seopage();
		$objSeo 		= new HT_Model_administrator_models_seo();
		$objNews 		= new HT_Model_administrator_models_news();
		$objConvert 	= new HT_Model_administrator_models_convert();
		$seoLink		= $objSeopage->getAllSeoPage();
		$data = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
		$data .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\r\n";
		
		$data .= '<url>'."\r\n";
		$data .= '<loc>http://www.goodgood.vn/dich-vu-seo-tu-khoa-trung-dich-chi-nhan-tien-khi-tu-khoa-da-len-top-google.html</loc>'."\r\n";
		$data .= '<lastmod>'.date('Y-m-d').'</lastmod>'."\r\n";
		$data .= ' <changefreq>daily</changefreq>'."\r\n";
		$data .= '<priority>0.8</priority>'."\r\n";
		$data .= '</url>'."\r\n";

		if(is_array($seoLink) && sizeof($seoLink) >0){
			foreach((array)$seoLink as $seo){
				$data .= '<url>'."\r\n";
				$data .= '<loc>'.WEB_PATH.'/nen-doc/'.$objConvert->utf8_to_url($seo['tag_title']).'-'.$seo['seopage_id'].'.html</loc>'."\r\n";
				$data .= '<lastmod>'.date('Y-m-d').'</lastmod>'."\r\n";
				$data .= ' <changefreq>daily</changefreq>'."\r\n";
				$data .= '<priority>0.8</priority>'."\r\n";
				$data .= '</url>'."\r\n";
			}
		}

		$newsLink = $objNews->getNewsForSitemap();
		if(is_array($newsLink) && sizeof($newsLink) >0){
			foreach((array)$newsLink as $news){
				$data .= '<url>'."\r\n";
				$data .= '<loc>'.WEB_PATH.'/tin-tuc/chi-tiet/'.$news['newsId'].'/'.$objConvert->utf8_to_url($news['title']).'.html</loc>'."\r\n";
				$data .= '<lastmod>'.date('Y-m-d').'</lastmod>'."\r\n";
				$data .= ' <changefreq>daily</changefreq>'."\r\n";
				$data .= '<priority>0.8</priority>'."\r\n";
				$data .= '</url>'."\r\n";
			}
		}

		$seoLink = $objSeo->getAllSeoLink();
		if(is_array($seoLink) && sizeof($seoLink) >0){
			foreach((array)$seoLink as $seo){
				$data .= '<url>'."\r\n";
				$data .= '<loc>'.$seo['url'].'</loc>'."\r\n";
				$data .= '<lastmod>'.date('Y-m-d').'</lastmod>'."\r\n";
				$data .= ' <changefreq>daily</changefreq>'."\r\n";
				$data .= '<priority>0.8</priority>'."\r\n";
				$data .= '</url>'."\r\n";
			}
		}


		$groupLink = $objSeogroup->getTodaySeoGroup();
		if(is_array($groupLink) && sizeof($groupLink) >0){
			foreach((array)$groupLink as $group){
				$data .= '<url>'."\r\n";
				$data .= '<loc>'.WEB_PATH.'/chu-de-nen-doc/'.$objConvert->utf8_to_url($group['subject']).'-'.$group['group_id'].'.html</loc>'."\r\n";
				$data .= '<lastmod>'.date('Y-m-d').'</lastmod>'."\r\n";
				$data .= ' <changefreq>daily</changefreq>'."\r\n";
				$data .= '<priority>0.8</priority>'."\r\n";
				$data .= '</url>'."\r\n";
			}
		}


		$data .= '</urlset>'."\r\n";
		return $data;
	}

}
?>