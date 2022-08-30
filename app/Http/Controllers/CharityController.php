<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CharityController extends BaseController
{

    public function showCharity() {
        $response = [
            "bitcoin"=>[
                "title"=>"BTC-Bitcoin",
                "address"=>"3GgMuS3FKiAck5nTxLBLymUug7tVYbPBsZ",
            ],
            "eth"=>[
                "title"=>"Ethereum ETH (ERC20)",
                "address"=>"0x993de686f89270864ec2904efc385c1716815775",
            ],
        ];

        return view('charity.show-charity', compact("response"));
    }
}
