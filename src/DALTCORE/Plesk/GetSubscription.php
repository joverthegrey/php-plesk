<?php
namespace DALTCORE\Plesk;

use DALTCORE\Plesk\Helper\Xml;

class GetSubscription extends BaseRequest
{
    /**
     * @var string
     */
    public $xml_packet = <<<EOT
<?xml version="1.0"?>
<packet version="1.6.3.0">
<webspace>
    <get>
        {FILTER}
        <dataset>
			<hosting/>
			<subscriptions/>
		</dataset>
    </get>
</webspace>
</packet>
EOT;

    /**
     * @var array
     */
    protected $default_params = [
        'filter' => null,
    ];

    /**
     * @param array $config
     * @param array $params
     * @throws ApiRequestException
     */
    public function __construct($config, $params = [])
    {
        $this->default_params['filter'] = new Node('filter');

        if (!empty($params)) {
            $params['filter'] = new Node('filter', $this->createFilter($params));
        }
        parent::__construct($config, $params);
    }

    /**
     * Create a filter
     *
     * @param array $params
     * @return NodeList
     */
    private function createFilter($params = [])
    {
        $nodes = [];
        $validNodes = [
            'id', 'subscription_id',
            'owner-id', 'name',
            'owner-login', 'guid',
            'owner-guid',
            'external-id',
            'owner-external-id'
        ];

        foreach ($validNodes as $nodeName) {
            if (isset($params[$nodeName])) {
                if (!is_array($params[$nodeName])) {
                    $params[$nodeName] = [$params[$nodeName]];
                }

                foreach ($params[$nodeName] as $value) {
                    // create new node (if needed with a rewritten node name)
                    $nodes[] = new Node($nodeName == 'subscription_id' ? 'id' : $nodeName, $value);
                }
            }
        }

        return new NodeList($nodes);
    }

    /**
     * @param $xml
     * @return array
     */
    protected function processResponse($xml)
    {
        $result = [];

        for ($i = 0; $i < count($xml->webspace->get->result); $i++) {
            $webspace = $xml->webspace->get->result[$i];

            // nothing found or an error occurred, do an early return
            if (!isset($webspace->data) || $webspace->status == 'error') {
                return $result;
            }

            $hosting = [];
            foreach ($webspace->data->hosting->children() as $host) {
                $hosting[$host->getName()] = Xml::getProperties($host);
            }

            $subscriptions = [];
            foreach ($webspace->data->subscriptions->children() as $subscription) {
                $subscriptions[] = [
                    'locked' => (bool)$subscription->locked,
                    'synchronized' => (bool)$subscription->synchronized,
                    'plan-guid' => (string)$subscription->plan->{"plan-guid"},
                ];
            }

            $result[] = [
                'id' => (string)$webspace->id,
                'status' => (string)$webspace->status,
                'subscription_status' => (int)$webspace->data->gen_info->status,
                'created' => (string)$webspace->data->gen_info->cr_date,
                'name' => (string)$webspace->data->gen_info->name,
                'owner_id' => (string)$webspace->data->gen_info->{"owner-id"},
                'hosting' => $hosting,
                'real_size' => (int)$webspace->data->gen_info->real_size,
                'dns_ip_address' => (string)$webspace->data->gen_info->dns_ip_address,
                'htype' => (string)$webspace->data->gen_info->htype,
                'subscriptions' => $subscriptions,
            ];
        }

        return $result;
    }
}
