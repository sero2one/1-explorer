<?php

declare(strict_types=1);

namespace App\Services\Monitor;

use App\Facades\Network;
use App\Models\Block;
use Illuminate\Support\Collection;

final class DelegateTracker
{
    // const EXPECTED = [
    //     'input' => [
    //         '033a5474f68f92f254691e93c06a2f22efaf7d66b543a53efcece021819653a200',
    //         '0215789ac26155b7a338708f595b97c453e08918d0630c896cbd31d83fe2ad1c33',
    //         '03d60e675b8a4b461361689e29fcf809cc4724de57ad7e7f73825e16d7b092d338',
    //         '029918d8fe6a78cc01bbab31f636494568dd954431f75f4ea6ff1da040b7063a70',
    //         '03ccf15ff3a07e1a4b04692f7f2db3a06948708dacfff47661c259f2fa689e1941',
    //         '035c14e8c5f0ee049268c3e75f02f05b4246e746dc42f99271ff164b7be20cf5b8',
    //         '03d3c6889608074b44155ad2e6577c3368e27e6e129c457418eb3e5ed029544e8d',
    //         '02062f6f6d2aabafd745e6b01f4aa788a012c4ce7131312026bdb6eb4e74a464d2',
    //         '027716e659220085e41389efc7cf6a05f7f7c659cf3db9126caabce6cda9156582',
    //         '0352e9ea81b7fb78b80ab6598e66d23764249c77b9492e3c1b0705d9d0722b729f',
    //         '037850667ea2c8473adf7c87ee4496af1b7821f4e10761e78c3b391d6fcfbde9bb',
    //         '02ac8d84d81648154f79ba64fbf64cd6ee60f385b2aa52e8eb72bc1374bf55a68c',
    //         '032cfbb18f4e49952c6d6475e8adc6d0cba00b81ef6606cc4927b78c6c50558beb',
    //         '0242555e90957de10e3912ce8831bcc985a40a645447dbfe8a0913ee6d89914707',
    //         '02677f73453da6073f5cf76db8f65fabc1a3b7aadc7b06027e0df709f14e097790',
    //         '0236d5232cdbd1e7ab87fad10ebe689c4557bc9d0c408b6773be964c837231d5f0',
    //         '02789894f309f08a4e7833452552aa39e168005d893cafc8ef995edbfdba396d2c',
    //         '03f3512aa9717b2ca83d371ed3bb2d3ff922969f3ceef92f65c060afa2bc2244fb',
    //         '039b5a3a71335bfa6c72b82498f814123e0678f7cd3d8e7221ec7124918736e01c',
    //         '023ee98f453661a1cb765fd60df95b4efb1e110660ffb88ae31c2368a70f1f7359',
    //         '02e345079aca0567db96ec0ba3acf859b7cfd15134a855671f9c0fe8b1173767bd',
    //         '0304d0c477d634cc85d89c1a4afee8f51168d1747fe8fd79cabc26565e49eb8a7a',
    //         '0284a88da69cc04439633217c6961d2800df0f7dff7f85b9803848ee02d0743f1d',
    //         '02d2f48a7ebb5b6d484de15b4cab8ab13c1d39b7141301efe048714aa9d82eb1cd',
    //         '03380be01971b9f58131974234d466adca4889cb8e9616d64166980370e6bf1157',
    //         '024d5eacc5e05e1b05c476b367b7d072857826d9b271e07d3a3327224db8892a21',
    //         '02747353898e59c4f784542f357d5dd938a2872adb53abb94924091fddfdd83dc3',
    //         '037997a6553ea8073eb199e9f5ff23b8f0892e79433ef35e13966e0a12849d02e3',
    //         '02d0244d939fad9004cc104f71b46b428d903e4f2988a65f39fdaa1b7482894c9e',
    //         '023e3b421c730f85d2db546ee58f2b8d81dc141c3b12f8b8efadba8ddf085a4db6',
    //         '03b12f99375c3b0e4f5f5c7ea74e723f0b84a6f169b47d9105ed2a179f30c82df2',
    //         '025341ecfcbb48f9ecac8b87d6e5ace9fb172cee9c521a036f20861f515077bfc3',
    //         '02cd9f56a176c843724eb58d3ef89dc88915a814bdcf284b02933e0dd203630a83',
    //         '031a6d8dab63668e901661c592dfe4bcc75793959d6ee6300408482840487d1faf',
    //         '02257c58004e5ae23716d1c44beea0cca7f5b522a692df367bae9015a4f15c1670',
    //         '022ffb5fa4eb5b2e71c985b1d796642528802f04a6ddf9a449ba1aab292a9744aa',
    //         '03153c994e5306b2fbba9bb533f22871e12e4c1d1d3960d1eeef385ab143b258b4',
    //         '02951227bb3bc5309aeb96460dbdf945746012810bb4020f35c20feae4eea7e5d4',
    //         '0296893488d335ff818391da7c450cfeb7821a4eb535b15b95808ea733915fbfb1',
    //         '0250b742256f9321bd7d46f3ed9769b215a7c2fb02be951acf43bc51eb57ceadf6',
    //         '03b906102928cf97c6ddeb59cefb0e1e02105a22ab1acc3b4906214a16d494db0a',
    //         '03dcb84917cf6d7b742f58c04693c5e00c56a4ae83feec129b3e3cc27111796232',
    //         '02c3d1ae1b8fe831218f78cf09d864e60818ebdba4aacc74ecc2bcf2734aadf5ea',
    //         '0306950dae7158103814e3828b1ab97a87dbb3680db1b4c6998b8208865b2f9db7',
    //         '022eedf9f1cdae0cfaae635fe415b6a8f1912bc89bc3880ec41135d62cbbebd3d3',
    //         '02adfadcf8b9c8c1925c8662ac9cde0763c92b06404dfffad8555f41638cdf4780',
    //         '03ce92e54f9dbb5e4a050edddf5862dee29f419c60ceaad052d50aad6fcced5652',
    //         '03a8ff0a3cbdcb3bfbdb84dbf83226f338ba1452047ac5b8228a1513f7f1de80de',
    //         '02e311d97f92dc879860ec0d63b344239f17149ed1700b279b5ef52d2baaa0226f',
    //         '03eda1b9127d9a12a7c6903ca896534937ec492afa12ffa57a9aa6f3c77b618fdb',
    //         '03f6af8c750b9d29d9da3d4ddf5818a1fcdd4558ba0dde731f9c4b17bcbdcd83f2',
    //     ],
    //     'seeds'  => [
    //         '2f4ea6180ed7858311ec2c3e8b6b29e4767c27972419700ddd9f577b2b36a20e' => [
    //             [
    //                 'i'        => 0,
    //                 'x'        => 0,
    //                 'newIndex' => 47,
    //             ],
    //             [
    //                 'i'        => 1,
    //                 'x'        => 1,
    //                 'newIndex' => 27,
    //             ],
    //             [
    //                 'i'        => 2,
    //                 'x'        => 2,
    //                 'newIndex' => 13,
    //             ],
    //             [
    //                 'i'        => 3,
    //                 'x'        => 3,
    //                 'newIndex' => 24,
    //             ],
    //         ],
    //         '8eb9cd160b0b5a4fea2bb414f503f9f928964d5a9163911ab430a8a06a77d307' => [
    //             [
    //                 'i'        => 5,
    //                 'x'        => 0,
    //                 'newIndex' => 40,
    //             ],
    //             [
    //                 'i'        => 6,
    //                 'x'        => 1,
    //                 'newIndex' => 32,
    //             ],
    //             [
    //                 'i'        => 7,
    //                 'x'        => 2,
    //                 'newIndex' => 1,
    //             ],
    //             [
    //                 'i'        => 8,
    //                 'x'        => 3,
    //                 'newIndex' => 22,
    //             ],
    //         ],
    //         '9c1cdc977af17509fdbc2190f858fa456f1d5d400199358ba9ddf3124844c2c3' => [
    //             [
    //                 'i'        => 10,
    //                 'x'        => 0,
    //                 'newIndex' => 3,
    //             ],
    //             [
    //                 'i'        => 11,
    //                 'x'        => 1,
    //                 'newIndex' => 28,
    //             ],
    //             [
    //                 'i'        => 12,
    //                 'x'        => 2,
    //                 'newIndex' => 16,
    //             ],
    //             [
    //                 'i'        => 13,
    //                 'x'        => 3,
    //                 'newIndex' => 49,
    //             ],
    //         ],
    //         '82f040d5f3cfe837a254b18269f4bc2ee274d123a433f1507ded7a6622403164' => [
    //             [
    //                 'i'        => 15,
    //                 'x'        => 0,
    //                 'newIndex' => 28,
    //             ],
    //             [
    //                 'i'        => 16,
    //                 'x'        => 1,
    //                 'newIndex' => 36,
    //             ],
    //             [
    //                 'i'        => 17,
    //                 'x'        => 2,
    //                 'newIndex' => 13,
    //             ],
    //             [
    //                 'i'        => 18,
    //                 'x'        => 3,
    //                 'newIndex' => 9,
    //             ],
    //         ],
    //         'b5c5a57c8a29ae9ba00519c1b333929b96c7cc394a42b12ccaa6d88a2b3e683d' => [
    //             [
    //                 'i'        => 20,
    //                 'x'        => 0,
    //                 'newIndex' => 28,
    //             ],
    //             [
    //                 'i'        => 21,
    //                 'x'        => 1,
    //                 'newIndex' => 44,
    //             ],
    //             [
    //                 'i'        => 22,
    //                 'x'        => 2,
    //                 'newIndex' => 12,
    //             ],
    //             [
    //                 'i'        => 23,
    //                 'x'        => 3,
    //                 'newIndex' => 22,
    //             ],
    //         ],
    //         '9bba197b485a7f1fd3d16b9a8b5196680aa1c7b595ca73e707135afb3818c3a2' => [
    //             [
    //                 'i'        => 25,
    //                 'x'        => 0,
    //                 'newIndex' => 2,
    //             ],
    //             [
    //                 'i'        => 26,
    //                 'x'        => 1,
    //                 'newIndex' => 33,
    //             ],
    //             [
    //                 'i'        => 27,
    //                 'x'        => 2,
    //                 'newIndex' => 25,
    //             ],
    //             [
    //                 'i'        => 28,
    //                 'x'        => 3,
    //                 'newIndex' => 21,
    //             ],
    //         ],
    //         'fc59a04f9737128dd0b9fda36d1bd1a2466d4c4e91904387c536f4bd7ef629d7' => [
    //             [
    //                 'i'        => 30,
    //                 'x'        => 0,
    //                 'newIndex' => 48,
    //             ],
    //             [
    //                 'i'        => 31,
    //                 'x'        => 1,
    //                 'newIndex' => 38,
    //             ],
    //             [
    //                 'i'        => 32,
    //                 'x'        => 2,
    //                 'newIndex' => 7,
    //             ],
    //             [
    //                 'i'        => 33,
    //                 'x'        => 3,
    //                 'newIndex' => 28,
    //             ],
    //         ],
    //         '257d6656593bf6f2ad43ee584228c70b0a30b015e25abbba1c48770199cd0289' => [
    //             [
    //                 'i'        => 35,
    //                 'x'        => 0,
    //                 'newIndex' => 37,
    //             ],
    //             [
    //                 'i'        => 36,
    //                 'x'        => 1,
    //                 'newIndex' => 23,
    //             ],
    //             [
    //                 'i'        => 37,
    //                 'x'        => 2,
    //                 'newIndex' => 0,
    //             ],
    //             [
    //                 'i'        => 38,
    //                 'x'        => 3,
    //                 'newIndex' => 35,
    //             ],
    //         ],
    //         'b6a974e0ce1f5bf753bf3c54745ddf419287eea2f0c22067d525e4a5aee1e708' => [
    //             [
    //                 'i'        => 40,
    //                 'x'        => 0,
    //                 'newIndex' => 29,
    //             ],
    //             [
    //                 'i'        => 41,
    //                 'x'        => 1,
    //                 'newIndex' => 16,
    //             ],
    //             [
    //                 'i'        => 42,
    //                 'x'        => 2,
    //                 'newIndex' => 14,
    //             ],
    //             [
    //                 'i'        => 43,
    //                 'x'        => 3,
    //                 'newIndex' => 20,
    //             ],
    //         ],
    //         '27a6c2beac1f84668ed491b70e4a773e08b715918651cc24be29180a4c7a46b4' => [
    //             [
    //                 'i'        => 45,
    //                 'x'        => 0,
    //                 'newIndex' => 39,
    //             ],
    //             [
    //                 'i'        => 46,
    //                 'x'        => 1,
    //                 'newIndex' => 13,
    //             ],
    //             [
    //                 'i'        => 47,
    //                 'x'        => 2,
    //                 'newIndex' => 41,
    //             ],
    //             [
    //                 'i'        => 48,
    //                 'x'        => 3,
    //                 'newIndex' => 37,
    //             ],
    //         ],
    //         '8531625b73352a39d0b0bf6ff49e0e9dc54bd107c4be7c292835749306de1c65' => [
    //             [
    //                 'i'        => 50,
    //                 'x'        => 0,
    //                 'newIndex' => 31,
    //             ],
    //         ],
    //     ],
    //     'output' => [
    //         '022ffb5fa4eb5b2e71c985b1d796642528802f04a6ddf9a449ba1aab292a9744aa',
    //         '02062f6f6d2aabafd745e6b01f4aa788a012c4ce7131312026bdb6eb4e74a464d2',
    //         '024d5eacc5e05e1b05c476b367b7d072857826d9b271e07d3a3327224db8892a21',
    //         '037850667ea2c8473adf7c87ee4496af1b7821f4e10761e78c3b391d6fcfbde9bb',
    //         '03ccf15ff3a07e1a4b04692f7f2db3a06948708dacfff47661c259f2fa689e1941',
    //         '03b906102928cf97c6ddeb59cefb0e1e02105a22ab1acc3b4906214a16d494db0a',
    //         '02cd9f56a176c843724eb58d3ef89dc88915a814bdcf284b02933e0dd203630a83',
    //         '03d3c6889608074b44155ad2e6577c3368e27e6e129c457418eb3e5ed029544e8d',
    //         '0284a88da69cc04439633217c6961d2800df0f7dff7f85b9803848ee02d0743f1d',
    //         '039b5a3a71335bfa6c72b82498f814123e0678f7cd3d8e7221ec7124918736e01c',
    //         '03380be01971b9f58131974234d466adca4889cb8e9616d64166980370e6bf1157',
    //         '02d0244d939fad9004cc104f71b46b428d903e4f2988a65f39fdaa1b7482894c9e',
    //         '027716e659220085e41389efc7cf6a05f7f7c659cf3db9126caabce6cda9156582',
    //         '03ce92e54f9dbb5e4a050edddf5862dee29f419c60ceaad052d50aad6fcced5652',
    //         '02c3d1ae1b8fe831218f78cf09d864e60818ebdba4aacc74ecc2bcf2734aadf5ea',
    //         '02ac8d84d81648154f79ba64fbf64cd6ee60f385b2aa52e8eb72bc1374bf55a68c',
    //         '03dcb84917cf6d7b742f58c04693c5e00c56a4ae83feec129b3e3cc27111796232',
    //         '03eda1b9127d9a12a7c6903ca896534937ec492afa12ffa57a9aa6f3c77b618fdb',
    //         '0352e9ea81b7fb78b80ab6598e66d23764249c77b9492e3c1b0705d9d0722b729f',
    //         '023ee98f453661a1cb765fd60df95b4efb1e110660ffb88ae31c2368a70f1f7359',
    //         '0306950dae7158103814e3828b1ab97a87dbb3680db1b4c6998b8208865b2f9db7',
    //         '02e345079aca0567db96ec0ba3acf859b7cfd15134a855671f9c0fe8b1173767bd',
    //         '02d2f48a7ebb5b6d484de15b4cab8ab13c1d39b7141301efe048714aa9d82eb1cd',
    //         '032cfbb18f4e49952c6d6475e8adc6d0cba00b81ef6606cc4927b78c6c50558beb',
    //         '029918d8fe6a78cc01bbab31f636494568dd954431f75f4ea6ff1da040b7063a70',
    //         '0215789ac26155b7a338708f595b97c453e08918d0630c896cbd31d83fe2ad1c33',
    //         '031a6d8dab63668e901661c592dfe4bcc75793959d6ee6300408482840487d1faf',
    //         '0242555e90957de10e3912ce8831bcc985a40a645447dbfe8a0913ee6d89914707',
    //         '02747353898e59c4f784542f357d5dd938a2872adb53abb94924091fddfdd83dc3',
    //         '035c14e8c5f0ee049268c3e75f02f05b4246e746dc42f99271ff164b7be20cf5b8',
    //         '02e311d97f92dc879860ec0d63b344239f17149ed1700b279b5ef52d2baaa0226f',
    //         '03f6af8c750b9d29d9da3d4ddf5818a1fcdd4558ba0dde731f9c4b17bcbdcd83f2',
    //         '037997a6553ea8073eb199e9f5ff23b8f0892e79433ef35e13966e0a12849d02e3',
    //         '022eedf9f1cdae0cfaae635fe415b6a8f1912bc89bc3880ec41135d62cbbebd3d3',
    //         '02257c58004e5ae23716d1c44beea0cca7f5b522a692df367bae9015a4f15c1670',
    //         '025341ecfcbb48f9ecac8b87d6e5ace9fb172cee9c521a036f20861f515077bfc3',
    //         '02789894f309f08a4e7833452552aa39e168005d893cafc8ef995edbfdba396d2c',
    //         '03b12f99375c3b0e4f5f5c7ea74e723f0b84a6f169b47d9105ed2a179f30c82df2',
    //         '02951227bb3bc5309aeb96460dbdf945746012810bb4020f35c20feae4eea7e5d4',
    //         '02adfadcf8b9c8c1925c8662ac9cde0763c92b06404dfffad8555f41638cdf4780',
    //         '023e3b421c730f85d2db546ee58f2b8d81dc141c3b12f8b8efadba8ddf085a4db6',
    //         '033a5474f68f92f254691e93c06a2f22efaf7d66b543a53efcece021819653a200',
    //         '02677f73453da6073f5cf76db8f65fabc1a3b7aadc7b06027e0df709f14e097790',
    //         '0236d5232cdbd1e7ab87fad10ebe689c4557bc9d0c408b6773be964c837231d5f0',
    //         '0304d0c477d634cc85d89c1a4afee8f51168d1747fe8fd79cabc26565e49eb8a7a',
    //         '0250b742256f9321bd7d46f3ed9769b215a7c2fb02be951acf43bc51eb57ceadf6',
    //         '03f3512aa9717b2ca83d371ed3bb2d3ff922969f3ceef92f65c060afa2bc2244fb',
    //         '03153c994e5306b2fbba9bb533f22871e12e4c1d1d3960d1eeef385ab143b258b4',
    //         '03a8ff0a3cbdcb3bfbdb84dbf83226f338ba1452047ac5b8228a1513f7f1de80de',
    //         '03d60e675b8a4b461361689e29fcf809cc4724de57ad7e7f73825e16d7b092d338',
    //         '0296893488d335ff818391da7c450cfeb7821a4eb535b15b95808ea733915fbfb1',
    //     ],
    // ];

    public static function execute(Collection $delegates): array
    {
        // Arrange Block
        $lastBlock = Block::current();
        $height    = $lastBlock->height->toNumber(); // 5720529;
        $timestamp = $lastBlock->timestamp; // 113620904;

        // Arrange Delegates
        $activeDelegates = $delegates->toBase()->map(fn ($delegate) => $delegate->public_key);

        // dump([
        //     'INPUT_EQUAL' => $activeDelegates->toArray() === static::EXPECTED['input'],
        //     'INPUT_DIFFS' => array_diff($activeDelegates->toArray(), static::EXPECTED['input']),
        // ]);

        $activeDelegates = static::getActiveDelegates($activeDelegates->toArray(), $height);

        // dd([
        //     'OUTPUT_EQUAL' => $activeDelegates === static::EXPECTED['output'],
        //     'OUTPUT_DIFFS' => array_diff($activeDelegates, static::EXPECTED['output']),
        // ]);

        // Arrange Constants
        $maxDelegates = Network::delegateCount();
        $blockTime    = Network::blockTime();

        // Act
        $forgingInfo = ForgingInfoCalculator::calculate($timestamp, $height);

        // Determine Next Forgers...
        $nextForgers = [];
        for ($i = 0; $i < $maxDelegates; $i++) {
            $delegate = $activeDelegates[($forgingInfo['currentForger'] + $i) % $maxDelegates];

            if ($delegate) {
                $nextForgers[] = $delegate;
            }
        }

        // Map Next Forgers...
        $result = [
            // 'delegates'     => [],
            // 'nextRoundTime' => ($maxDelegates - $forgingInfo['currentForger'] - 1) * $blockTime,
        ];

        foreach ($delegates as $delegate) {
            $indexInNextForgers = 0;

            for ($i = 0; $i < count($nextForgers); $i++) {
                if ($nextForgers[$i] === $delegate->public_key) {
                    $indexInNextForgers = $i;

                    break;
                }
            }

            if ($indexInNextForgers === 0) {
                $result[$indexInNextForgers] = [
                    'publicKey' => $delegate->public_key,
                    'status'    => 'next',
                    'time'      => 0,
                    'order'     => $indexInNextForgers,
                ];
            } elseif ($indexInNextForgers <= $maxDelegates - $forgingInfo['nextForger']) {
                $result[$indexInNextForgers] = [
                    'publicKey' => $delegate->public_key,
                    'status'    => 'pending',
                    'time'      => $indexInNextForgers * $blockTime * 1000,
                    'order'     => $indexInNextForgers,
                ];
            } else {
                $result[$indexInNextForgers] = [
                    'publicKey' => $delegate->public_key,
                    'status'    => 'done',
                    'time'      => 0,
                    'order'     => $indexInNextForgers,
                ];
            }
        }

        return collect($result)->sortBy('order')->toArray();
    }

    private static function getActiveDelegates(array $delegates, int $height): array
    {
        $seedSource  = (string) RoundCalculator::calculate($height)['round'];
        $currentSeed = hex2bin(hash('sha256', $seedSource));
        $delCount    = count($delegates);

        $seeds = [];
        for ($i = 0; $i < $delCount; $i++) {
            $elements = [];

            for ($x = 0; $x < 4 && $i < $delCount; $i++, $x++) {
                $newIndex             = intval(unpack('C*', $currentSeed)[$x + 1]) % $delCount;
                $b                    = $delegates[$newIndex];
                $delegates[$newIndex] = $delegates[$i];
                $delegates[$i]        = $b;

                $elements[] = [
                    'i'        => $i,
                    'x'        => $x,
                    'newIndex' => $newIndex,
                ];
            }

            $seeds[bin2hex($currentSeed)] = $elements;

            $currentSeed = hex2bin(hash('sha256', $currentSeed));
        }

        // dump([
        //     'SEEDS_EQUAL' => array_keys($seeds) === array_keys(static::EXPECTED['seeds']),
        //     'SEEDS_DIFFS' => array_diff(array_keys($seeds), array_keys(static::EXPECTED['seeds'])),
        // ]);

        // foreach ($seeds as $hash => $actual) {
        //     $expected = static::EXPECTED['seeds'][$hash];

        //     for ($i = 0; $i < count($expected); $i++) {
        //         dump([
        //             'i'        => $expected[$i]['i'] === $actual[$i]['i'],
        //             'x'        => $expected[$i]['x'] === $actual[$i]['x'],
        //             'newIndex' => $expected[$i]['newIndex'] === $actual[$i]['newIndex'],
        //             'expected' => $expected[$i],
        //             'actual'   => $actual[$i],
        //         ]);
        //     }
        // }

        return $delegates;
    }
}