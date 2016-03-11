<?php


namespace Visitmedia\FindologicClient;


class SimpleXMLElementConverter
{
    /**
     * @param \SimpleXMLElement $element
     * @param null $arrayEncoding
     * @param null $elementEncoding
     * @return array
     */
    public static function lossyToArray(\SimpleXMLElement $element, $arrayEncoding = null, $elementEncoding = null)
    {
        $result = [];
        /** @var \SimpleXMLElement $child */
        foreach($element as $child) {
            $text = is_string($arrayEncoding) && is_string($elementEncoding)
                ? mb_convert_encoding((string)$child, $arrayEncoding, $elementEncoding)
                : (string)$child;

            // This is stupid but necessary
            $attributes = array();
            foreach($child->attributes() as $key => $val) {
                $attributes[$key] = (string)$val;
            }

            if($child->count() == 0 && $child->attributes()->count() == 0) {
                $result[$child->getName()] = $text;
            } else {
                $subresult = ["_text" => $text, "_attributes" => $child->attributes()];
                $newItem = ($child->count() > 0)
                    ? array_merge(static::lossyToArray($child, $arrayEncoding, $elementEncoding), $subresult)
                    : $subresult;
                $result[$child->getName()] = $newItem;
            }
        }
        return $result;
    }
}
