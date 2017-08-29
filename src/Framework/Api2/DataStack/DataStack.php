<?php declare(strict_types=1);

namespace Shopware\Framework\Api2\DataStack;

/**
 * Start with original raw result
 *  -> each step removes one from the raw set and possibly adds one to the result set
 * if raw set is empty, reiterate the result set
 *  -> if skipped => KEEP
 *  -> if used
 *      -> if not array and a different key comes back -> REMOVE
 *      -> if array with same key -> UPDATE RECURSIVELY
 *
 *      foreach($keys as KEY) {
 *
 *          if(!$stack->has('KEY')) {
 *              skip;
 *          }
 *
 *          $kvPair = $stack->pop('KEY');
 *
 *          foreach($provider($kvPair) as $key => $value) {
 *              $stack->update($kvPair, $key, $value); // determine state
 *          }
 *
 *
 *      }
 *
 *      $resultSet = $stack->getResultAsArray();
 *
 */
class DataStack
{
    /**
     * @var KeyValuePair[]
     */
    private $data = [];

    /**
     * @param array $originalData
     */
    public function __construct(array $originalData)
    {
        foreach ($originalData as $key => $value) {
            $this->data[$key] = new KeyValuePair($key, $value, true);
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * @param string $key
     * @return KeyValuePair
     * @throws ExceptionNoStackItemFound
     */
    public function pop(string $key): KeyValuePair
    {
        if(!$this->has($key)) {
            throw new ExceptionNoStackItemFound(sprintf('Unable to find %s', $key));
        }

        $pair = $this->data[$key];
        unset($this->data[$key]);
        return $pair;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function update(string $key, $value): void
    {
        if(!$this->has($key)) {
            $this->data[$key] = new KeyValuePair($key, $value, false);
            return;
        }

        $preExistingPair = $this->data[$key];

        if(!is_array($value) || !is_array($preExistingPair->getValue())) {
            $this->data[$key] = new KeyValuePair($key, $value, false);
            return;
        }

        $this->data[$key] = new KeyValuePair(
            $key,
            array_replace_recursive($preExistingPair->getValue(), $value),
            false
        );
    }

    /**
     * @return array
     */
    public function getResultAsArray(): array
    {
        $resultPairs = array_filter($this->data, function(KeyValuePair $kvPair) {
            return !$kvPair->isRaw();
        });

        $result = [];
        foreach ($resultPairs as $kvPair) {
            $result[$kvPair->getKey()] = $kvPair->getValue();
        }

        return $result;
    }
}
