<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Services\Shiping\SMSAShipingService;
use Symfony\Component\DomCrawler\Crawler;

class ShowOrderTracking extends Component
{
    public $searchText;
    public $data = [], $result = [];
    public $tracking_id;


    // Function to convert date format
    public  function convertDateFormat($data)
    {
        foreach ($data as &$item) {
            if (isset($item['date'])) {
                $item['date'] = date('Y-m-d H:i:s', strtotime($item['date']));
            }
        }
        return $data;
    }

    public function search()
    {
        $this->data = DB::table('orders')
            ->select('order_trackings.*')
            ->join('order_trackings', 'order_trackings.order_id', '=', 'orders.id')
            ->where('orders.tracking_number', $this->searchText)
            ->orderBy('id', 'desc')
            ->get();

        if ($this->data->isEmpty()) {
            session()->flash('error', __('translation.data.not.found'));
            return;
        }

        foreach ($this->data as $item) {
            if (isset($item->date)) {
                $item->date = date('Y-m-d H:i:s', strtotime($item->date));
            }
        }

        $ordersShipping = Order::with('Shipping')->where('id', $this->data->first()->order_id)->get();
        if ($ordersShipping && $ordersShipping->first()->Shipping) {
            // Initialize cURL session
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://www.smsaexpress.com/ae/ar/trackingdetails?tracknumbers%5B0%5D='. (string) $ordersShipping->first()->Shipping->refrence_id);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl);
            if ($html === false) {
                $error = curl_error($curl);
                //   dd("cURL Error: $error");
            }

            curl_close($curl);
            //dd($html);

            // Parse the HTML and extract tracking data
            $objectData = $this->parseHTML($html); // Assume parseHTML is a method that parses the HTML and returns tracking data as an array

            // Merge order tracking data with scraped data
            $combinedData = $objectData;//$this->data->merge($objectData);
        } else {
            $combinedData = $this->data;
        }
        $combinedData = $combinedData instanceof \Illuminate\Support\Collection ? $combinedData : collect($combinedData);

        $combinedData = $combinedData->map(function ($item) {
            $other = isset($item->status) ? ' , ' . $item->status : ' , ' . $item["location"];
            $date = isset($item->date) ? $item->date : $item["date"];
            $note = isset($item->note) ? $item->note : $item["description"];
            $formattedDate = $date ? date('Y-m-d H:i:s', strtotime($date)) : null;
            return ['date' => $formattedDate, 'note' => $note . $other];
        });

        $combinedData = $combinedData->filter(function ($item) {
            return isset($item['date']) && !empty($item['date']);
        });

        $this->data = $combinedData->sortByDesc('date')->values()->all();
    }

    private function parseHTML($html)
    {
        $crawler = new Crawler($html);

        // Mapping of Arabic month names to their numerical equivalents
        $months = [
            'يناير' => '01',
            'فبراير' => '02',
            'مارس' => '03',
            'أبريل' => '04',
            'مايو' => '05',
            'يونيو' => '06',
            'يوليو' => '07',
            'أغسطس' => '08',
            'سبتمبر' => '09',
            'أكتوبر' => '10',
            'نوفمبر' => '11',
            'ديسمبر' => '12',
        ];

        $results = [];

        $crawler->filter('.tracking-timeline .row')->each(function (Crawler $rowNode) use (&$results, $months) {
            $dateNode = $rowNode->filter('.date-wrap h4');
            $dateText = $dateNode->count() > 0 ? trim($dateNode->text()) : 'Unknown Date';

            // Attempt to reformat the date
            $dateParts = explode('-', $dateText);
            if (count($dateParts) == 3) {
                $day = $dateParts[0];
                $monthName = trim($dateParts[1]);
                $year = $dateParts[2];

                $month = array_key_exists($monthName, $months) ? $months[$monthName] : 'Unknown Month';
                $date = $day . '-' . $month . '-' . $year; // Reformat date as DD-MM-YYYY
            } else {
                $date = $dateText; // Use original text if parsing fails
            }

            $rowNode->filter('.tracking-details .trk-wrap')->each(function (Crawler $node) use ($date, &$results) {
                $timestamp = $node->filter('.trk-wrap-content-left span')->count() > 0 ? trim($node->filter('.trk-wrap-content-left span')->text()) : 'Unknown Timestamp';
                $location = $node->filter('.trk-wrap-content-right span')->count() > 0 ? trim($node->filter('.trk-wrap-content-right span')->text()) : 'Unknown Location';
                $description = $node->filter('h4')->count() > 0 ? trim($node->filter('h4')->text()) : 'Unknown Description';
                $description = str_replace('سمسا', 'بروفاست', $description);




                $dateTimeString = $date . ' ' . $timestamp;
                $dateTimeString = str_replace('مساء', 'PM', $dateTimeString);
                $dateTimeString = str_replace('صباحا', 'AM', $dateTimeString);
                $dateTime = \DateTime::createFromFormat('d-m-Y h:i A', $dateTimeString);
                 $dateString = $dateTime->format('Y-m-d H:i:s');

                $results[] = [
                    'date' => $dateString,
                    'timestamp' => $timestamp,
                    'location' => $location,
                    'description' => $description,
                ];
            });
        });

        return $results;
    }






    //     public function search()
    // {
    //     $this->data = DB::table('orders')
    //         ->select('order_trackings.*')
    //         ->join('order_trackings', 'order_trackings.order_id', '=', 'orders.id')
    //         ->where('orders.tracking_number', $this->searchText)
    //         ->orderBy('id', 'desc')
    //         ->get();

    //     if ($this->data->isEmpty()) {
    //         session()->flash('error', __('translation.data.not.found'));
    //         return;
    //     }

    //     // Convert date format for each item
    //     foreach ($this->data as $item) {
    //         if (isset($item->date)) {
    //             $item->date = date('Y-m-d H:i:s', strtotime($item->date));
    //         }
    //     }

    //     $ordersShipping = Order::with('Shipping')->where('id', $this->data->first()->order_id)->get();

    //     if ($ordersShipping && $ordersShipping->first()->Shipping) {
    //         $objectData = SMSAShipingService::Tracking($ordersShipping->first()->Shipping->refrence_id);

    //         // Merge order tracking data with object data
    //         $combinedData = $this->data->merge($objectData);
    //     } else {
    //         $combinedData = $this->data;
    //     }

    //     // Extract only 'date' and 'note' fields from each item
    //     $combinedData = $combinedData->map(function ($item) {
    //         $other = isset($item->status) ? ' , ' . $item->status : ' , ' . $item["activity"];
    //         $date = isset($item->date) ? $item->date : $item["date"];
    //         $note = isset($item->note) ? $item->note : $item["note"];
    //         $formattedDate = $date ? date('Y-m-d H:i:s', strtotime($date)) : null;
    //         return ['date' => $formattedDate, 'note' => $note . $other];
    //     });

    //     // Ensure dates are valid before sorting
    //     $combinedData = $combinedData->filter(function ($item) {
    //         return isset($item['date']) && !empty($item['date']);
    //     });

    //     // Sort the combined collection by date
    //     $this->data = $combinedData->sortByDesc('date')->values()->all();
    // }


    // public function search()
    // {
    //     $this->data = DB::table('orders')
    //         ->select('order_trackings.*')
    //         ->join('order_trackings', 'order_trackings.order_id', '=', 'orders.id')
    //         ->where('orders.tracking_number', $this->searchText)
    //         ->orderBy('id', 'desc')
    //         ->get();

    //     if ($this->data->isEmpty()) {
    //         session()->flash('error', __('translation.data.not.found'));
    //         return;
    //     }

    //     // Convert date format for each item
    //     foreach ($this->data as $item) {
    //         if (isset($item->date)) {
    //             $item->date = date('Y-m-d H:i:s', strtotime($item->date));
    //         }
    //     }

    //     $ordersShipping = Order::with('Shipping')->where('id',$this->data->first()->order_id)->get();
    //    // dd( $ordersShipping);

    //    //dd($this->data->first()->order_id);
    //     if ( $ordersShipping && $ordersShipping->first()->Shipping) {


    //         // Assuming SMSAShipingService::Tracking("290635573020") returns an array
    //         //dd($ordersShipping->first()->Shipping->refrence_id);
    //         $objectData = SMSAShipingService::Tracking($ordersShipping->first()->Shipping->refrence_id);
    //         //dd(  $objectData );

    //         //1710087

    //         // Merge order tracking data with object data
    //         $combinedData = $this->data->merge($objectData);

    //         // Sort the combined collection by date
    //         $combinedData = $combinedData->sortBy('date');
    //         //dd($combinedData);
    //         // Extract only 'date' and 'note' fields from each item
    //         $combinedData=$combinedData->map(function ($item) {
    //             $other = isset($item->status) ? ' , ' . $item->status :  ' , ' . $item["activity"];
    //             $date = isset($item->date) ? $item->date : $item["date"];
    //             $note = isset($item->note) ? $item->note :  $item["note"];
    //             $formattedDate = $date ? date('Y-m-d H:i:s', strtotime($date)) : null;
    //             return ['date' => $formattedDate, 'note' => $note . $other];
    //         })->sortBy('date');
    //         $combinedData = $combinedData->sortBy('date');
    //         $this->data = $combinedData->all();

    //         // dd(  $this->data);

    //     }else{

    //         $combinedData = $this->data;

    //         // Sort the combined collection by date
    //         $combinedData = $combinedData->sortBy('date');

    //         $this->data = $combinedData->map(function ($item) {
    //             $other = isset($item->status) ? ' , ' . $item->status :  ' , ' . $item["activity"];
    //             $date = isset($item->date) ? $item->date : $item["date"];
    //             $note = isset($item->note) ? $item->note :  $item["note"];
    //             $formattedDate = $date ? date('Y-m-d H:i:s', strtotime($date)) : null;
    //             return ['date' => $formattedDate, 'note' => $note . $other];
    //         })->all();
    //     }
    // }







    public function mount()
    {
        // dd($this->tracking_id);
        if ($this->tracking_id) {
            $this->searchText = $this->tracking_id;
            $this->search();
        }
    }
    public function render()
    {
        return view('livewire.show-order-tracking', [
            'data' => $this->data,
        ]);
    }
}
