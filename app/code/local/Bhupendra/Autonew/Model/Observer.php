<?php 
class Bhupendra_Autonew_Model_Observer {

  
	public function autoSave($observer)
	{
	  $enable=Mage::getStoreConfig("Bhupendra_autonew_options/configgroup/bhupendra_autonew_enable");	
	  $numberOfDays=Mage::getStoreConfig("Bhupendra_autonew_options/configgroup/bhupendra_autonew_days");
	  if($enable)
	  {	 
		$dateModel = Mage::getSingleton('core/date');
		$product = $observer->getProduct();
		$productId=$product->getId();
		if(!isset($productId)){
			$product->setNewsFromDate($dateModel->gmtDate());
			$product->setNewsToDate($dateModel->gmtDate(null, mktime(0,0,0, date('m'), date('d')+$numberOfDays, date('Y') )));
		}
		return $this;
	  }
	  
	}
	
	public function autoMetaSave($observer)
	{
	  $enable=Mage::getStoreConfig("Bhupendra_autonew_options/configgroup/bhupendra_autonew_enable");	
	  $template=Mage::getStoreConfig("Bhupendra_autonew_options/configgroup/bhupendra_autonew_metatemplate");
	  $description="";
	  $products=Mage::getModel("catalog/product")->getCollection();
		if($enable)
		{	 	 
			foreach($products as $temp)
			{
		 
			$product=Mage::getModel("catalog/product")->load($temp->getId());
			$description=str_replace("{{productname}}",$product->getName(),$template);
			$description=str_replace("{{price}}",$product->getPrice(),$description);
			$product->setMetaDescription($description);	
			$product->save();
			}
	  
		}
	}	
}