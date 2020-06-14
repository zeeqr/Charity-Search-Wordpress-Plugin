<?php // charity commission API Class

class charity_api {
	
	
	protected $wsdl;
	
	protected $APIKey;
	
	
	public function __construct() {
		
		$this->wsdl = "http://apps.charitycommission.gov.uk/Showcharity/API/SearchCharitiesV1/SearchCharitiesV1.asmx?wsdl";
		$this->APIKey = "6919d2eb-65ac-4397-b";

	}
	
	public function service_call($service, $params){
		$client = new SoapClient($this->wsdl);
		
		$params["APIKey"] = $this->APIKey;
		
		$response = $client->__soapCall($service,array($params));	
		
		
		return $response;
	}
	
	
	public function searchByKeyword($keyword){
		
		$params = array( "strSearch" => $keyword);
		
			$response = $this->service_call("GetCharitiesByKeyword",$params);
		
			if($response->GetCharitiesByKeywordResult->CharityList)
				return $response->GetCharitiesByKeywordResult->CharityList;
			else
				return array("error"=>"No Result Found for keyword: $keyword");
	}
	
	public function searchByName($name){
		
		$params = array( "strSearch" => $name);
		
			$response = $this->service_call("GetCharitiesByName",$params);
		
			if($response->GetCharitiesByNameResult->CharityList)
				return $response->GetCharitiesByNameResult->CharityList;
			else
				return array("error"=>"No Result Found for name: $name");
	}
	
	public function getCharityDetail($id){
		
		$params = array( "registeredCharityNumber" => $id);
		
			$response = $this->service_call("GetCharityByRegisteredCharityNumber",$params);

			if($response->GetCharityByRegisteredCharityNumberResult){
				$RegistrationHistory = $response->GetCharityByRegisteredCharityNumberResult->RegistrationHistory;
				if(is_array($RegistrationHistory)) $RegistrationHistory = $RegistrationHistory[count($RegistrationHistory)-1];
				
				if($date = $RegistrationHistory->RegistrationDate){
				$date = str_replace('/','-',$date);
				$RegistrationHistory->RegistrationDate = date('Y-m-d H:i:s',strtotime($date));
				}
				if($rdate = $RegistrationHistory->RegistrationRemovalDate){
				$rdate = str_replace('/','-',$rdate);
				$RegistrationHistory->RegistrationRemovalDate = date('Y-m-d H:i:s',strtotime($rdate));
				}
				
				$response->GetCharityByRegisteredCharityNumberResult->RegistrationHistory = $RegistrationHistory;
				return $response->GetCharityByRegisteredCharityNumberResult;
			}else
				return array("error"=>"Charity not found.");
	}
}


?>