<?php
class XMLHelper {
    /**
     * Generate ajax error page using XML
     *
     * @param string $message
     * @return string
     */
    public static function ajaxError( $message ) {
        $xml = new SimpleXMLElement( '<ajax/>' );
        $xml->addChild( 'error', htmlspecialchars( $message ) );

        return $xml->asXML();
    }

    /**
     * Generate ajax response page
     *
     * @param string $message
     * @return string
     */
    public static function ajaxResponse( $message ) {
        $xml = new SimpleXMLElement( '<ajax/>' );
        $xml->addChild( 'response', htmlspecialchars( $message ) );

        return $xml->asXML();
    }

    /**
     * Set XML-like headers
     *
     * @param Response $response
     */
    public static function setHeaders( $response ) {
        $response->header( 'Content-type', 'text/xml' );
    }
}