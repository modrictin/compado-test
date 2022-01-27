<?php

namespace App\Services\ApiAdapters;

use App\Actions\XmlDataConverter;
use App\Models\Product;
use App\Services\Apis\EbayApi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class EbayApiAdapter implements IApiAdapter
{
    private $ebayApi;

    public function __construct($appConfig)
    {
        $this->ebayApi = new EbayApi($appConfig['api_sources.ebay.APPKEY'],$appConfig['api_sources.ebay.endpoint']);
    }

    public function getKeywordItems($keyword,$priceMin=false,$priceMax=false,$sorting=IApiAdapter::SORT_DEFAULT): array
    {

        if($sorting == IApiAdapter::SORT_PRICE_ASC){
            $sorting = 'PricePlusShippingLowest';
        }else{
            $sorting = 'BestMatch';
        }

        $callResult  = XmlDataConverter::stringToObject( $this->ebayApi->getDataByKeyword($keyword,$priceMin,$priceMax,$sorting)) ;
        dd($callResult);
        if(!in_array($callResult->ack,[EbayApi::ACK_PARTIAL_FAILURE,EbayApi::ACK_SUCCESS,EbayApi::ACK_PARTIAL_FAILURE])){
            throw new \Exception('Api call failed to retrieve the data!');
        };

        $itemCollection = collect();
        if(!empty($callResult->searchResult['item'])){



            foreach($callResult->searchResult['item'] as $item){
                $mainPhotoUrl = $item['galleryURL'];
                if(key_exists('pictureURLSuperSize',$item)){
                    $mainPhotoUrl = $item['pictureURLSuperSize'];
                }else{
                    if(key_exists('pictureURLLarge',$item))
                        $mainPhotoUrl = $item['pictureURLLarge'];
                }
                $shippingServiceCost=0;

                if(key_exists('shippingServiceCost',$item['shippingInfo']))
                    $shippingServiceCost =  $item['shippingInfo']['shippingServiceCost'];

                $itemEnd = false;
                if(key_exists('listingInfo',$item) && key_exists('endTime',$item['listingInfo']))
                    $itemEnd = Carbon::make($item['listingInfo']['endTime']);

                $itemCollection->push(new Product([
                    'provider' =>'ebay',
                    'item_id'=>$item['itemId'],
                    'click_out_link'=>$item['viewItemURL'],
                    'main_photo_url'=>$mainPhotoUrl,
                    'price'=>$item['sellingStatus']['convertedCurrentPrice'],
                    'price_currency'=>'USD',
                    'shipping_price'=>$shippingServiceCost,
                    'title'=>key_exists('title',$item)?$item['title']:'',
                    'description'=>key_exists('subtitle',$item)?$item['subtitle']:'',
                    'valid_until'=>$itemEnd,
                    'brand'=>false,

                ]));
            }
        }


        return $itemCollection->toArray();
    }
}
