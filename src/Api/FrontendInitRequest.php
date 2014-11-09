<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class FrontendInitRequest extends WirecardRequest
{

    public function __construct()
    {
        $required = array(
            'customerId',
            'language',
            'paymentType',
            'amount',
            'currency',
            'orderDescription',
            'successUrl',
            'cancelUrl',
            'failureUrl',
            'serviceUrl',
            'confirmUrl',
            'consumerIpAddress',
            'consumerUserAgent',
            'requestFingerprintOrder');
        $optional = array(
            'financialInstitution',
            'pendingUrl',
            'noScriptInfoUrl',
            'orderNumber',
            'windowName',
            'duplicateRequestCheck',
            'customerStatement',
            'orderReference',
            'transactionIdentifier',
            'orderIdent',
            'storageId'
        );

        $requiredOrder = array();
        foreach ($required as $r)
        {
            $requiredOrder[$r] = true;
        }

        foreach ($optional as $o)
        {
            $requiredOrder[$o] = false;
        }

        $this->SetRequestFingerPrintOrder(join(',', array_merge($required, $optional)));

        parent::__construct('https://checkout.wirecard.com/seamless/frontend/init', $requiredOrder);
    }

    /**
     * Ordered list of parameters used for calculating the fingerprint.
     * @param string $value Alphanumeric with special characters.
     */
    private function SetRequestFingerPrintOrder($value)
    {
        $this->Set('requestFingerprintOrder', $value);
    }

    /**
     * Ordered list of parameters used for calculating the fingerprint.
     * @return string Alphanumeric with special characters.
     */
    public function GetRequestFingerPrintOrder()
    {
        return $this->Get('requestFingerprintOrder');
    }

    /**
     * The parameter paymentType contains the value of the payment method
     * the user selected in your online shop.
     *
     * @return string
     */
    public function GetPaymentType()
    {
        return $this->Get('paymentType');
    }

    /**
     * REQUIRED.
     * The parameter paymentType contains the value of the payment method
     * the user selected in your online shop.
     *
     * @param string $value One of: <ul>
     * <li>BANCONTACT_MISTERCASH</li>
     * <li>CCARD</li>
     * <li>CCARD-MOTO</li>
     * <li>EKONTO</li>
     * <li>EPAY_BG</li>
     * <li>EPS</li>
     * <li>GIROPAY</li>
     * <li>IDL</li>
     * <li>INSTALLMENT</li>
     * <li>INVOICE</li>
     * <li>MONETA</li>
     * <li>MPASS</li>
     * <li>PRZELEWY24</li>
     * <li>PAYPAL</li>
     * <li>PBX</li>
     * <li>POLI</li>
     * <li>PSC</li>
     * <li>QUICK</li>
     * <li>SEPA-DD</li>
     * <li>SKRILLDIRECT</li>
     * <li>SKRILLWALLET</li>
     * <li>SOFORTUEBERWEISUNG</li>
     * <li>TATRAPAY</li>
     * <li>TRUSTLY</li>
     * <li>VOUCHER</li>
     * </ul>
     */
    public function SetPaymentType($value)
    {
        $this->Set('paymentType', $value);
    }

    /**
     * The parameter amount specifies the amount of the payment to be done by
     * your consumer of your online shop.
     * @return string
     */
    public function GetAmount()
    {
        return $this->Get('amount');
    }

    /**
     * REQUIRED.
     * The parameter amount specifies the amount of the payment to be done by
     * your consumer of your online shop.
     *
     * @param string $value As a decimal separator only dot (”.”) or comma (”,”) are allowed values.
     * Thousand separators are not permitted. The maximum number of decimal
     * places depends on the selected currency within the currency parameter.
     */
    public function SetAmount($value)
    {
        $this->Set('amount', $value);
    }

    /**
     * The parameter currency defines the currency to be used for the payment
     * in conjunction with the amount of the payment.
     *
     * @return string
     */
    public function GetCurrency()
    {
        return $this->Get('currency');
    }

    /**
     * REQUIRED.
     * The parameter currency defines the currency to be used for the payment
     * in conjunction with the amount of the payment.
     *
     * Please be aware that by default only EUR is enabled to be used as
     * currency. If you would like to enable additional currencies for your
     * online shop please contact our support teams.     *
     *
     * @param string $value Is based on ISO 4217 and can either be an alphabetic
     *                      or numeric one.
     */
    public function SetCurrency($value)
    {
        $this->Set('currency', $value);
    }

    /**
     * The parameter orderDescription should contain a text cross-referencing
     * the order made in the online shop, e.g. basket id, consumer id,
     * e-mail, etc.
     *
     * This text is not transmitted to any financial service provider and is
     * therefore NEVER displayed on any consumer´s invoice or statement.
     * The text contained in the orderDescription is displayed in the Wirecard
     * Payment Center.
     *
     * If the optional request parameter displayText is not used, the
     * orderDescription text will also be visible as consumer information
     * in Wirecard Checkout Page.
     * @return string
     */
    public function GetOrderDescription()
    {
        return $this->Get('orderDescription');
    }

    /**
     * REQUIRED.
     * The parameter orderDescription should contain a text cross-referencing
     * the order made in the online shop, e.g. basket id, consumer id,
     * e-mail, etc.
     *
     * This text is not transmitted to any financial service provider and is
     * therefore NEVER displayed on any consumer´s invoice or statement.
     * The text contained in the orderDescription is displayed in the Wirecard
     * Payment Center.
     *
     * If the optional request parameter displayText is not used, the
     * orderDescription text will also be visible as consumer information
     * in Wirecard Checkout Page.
     *
     * @param string $value Must not contain any special characters or
     * line breaks. In addition, no special HTML characters such as foreign
     * characters, quotation marks (e.g. &auml or &Uuml;) should be included as
     * these could be converted by the browser itself. In this case it is
     * impossible for us to obtain the same initial string as you for computing
     * the fingerprint and an error message such as “Invalid fingerprint!”
     * would appear as a consequence.
     */
    public function SetOrderDescription($value)
    {
        $this->Set('orderDescription', $value);
    }

    /**
     * The parameter successUrl contains the URL of your online shop where your
     * onsumer is forwarded when the checkout process has been successfully
     * completed by your consumer. On this page of your online shop you should
     * inform your consumer about the success of the checkout process.
     *
     * @return string
     */
    public function GetSuccessUrl()
    {
        return $this->Get('successUrl');
    }

    /**
     * REQUIRED.
     * The parameter successUrl contains the URL of your online shop where your
     * onsumer is forwarded when the checkout process has been successfully
     * completed by your consumer. On this page of your online shop you should
     * inform your consumer about the success of the checkout process.
     *
     * @param string $value
     */
    public function SetSuccessUrl($value)
    {
        $this->Set('successUrl', $value);
    }

    /**
     * The parameter cancelUrl contains the URL of your online shop where your
     * consumer is forwarded when the checkout process has been cancelled by
     * your consumer. On this page of your online shop you should inform your
     * consumer about the cancelation of the checkout process and offer
     * possibilities to retry the payment attempt or get in contact with the
     * merchant.
     *
     * @return string
     */
    public function GetCancelUrl()
    {
        return $this->Get('cancelUrl');
    }

    /**
     * REQUIRED.
     * The parameter cancelUrl contains the URL of your online shop where your
     * consumer is forwarded when the checkout process has been cancelled by
     * your consumer. On this page of your online shop you should inform your
     * consumer about the cancelation of the checkout process and offer
     * possibilities to retry the payment attempt or get in contact with the
     * merchant.
     *
     * @param string $value Alphanumeric with special characters.
     */
    public function SetCancelUrl($value)
    {
        $this->Set('cancelUrl', $value);
    }

    /**
     * The parameter failureUrl contains the URL of your online shop where your
     * consumer is forwarded when the checkout process has failed for some
     * reason. On this page of your online shop you should inform your consumer
     * about the failure of the checkout process and offer possibilities to
     * retry the payment attempt or get in contact with the merchant.
     *
     * @return string
     */
    public function GetFailureUrl()
    {
        return $this->Get('failureUrl');
    }

    /**
     * REQUIRED.
     * The parameter failureUrl contains the URL of your online shop where your
     * consumer is forwarded when the checkout process has failed for some
     * reason. On this page of your online shop you should inform your consumer
     * about the failure of the checkout process and offer possibilities to
     * retry the payment attempt or get in contact with the merchant.
     *
     * @param string $value Alphanumeric with special characters.
     */
    public function SetFailureUrl($value)
    {
        $this->Set('failureUrl', $value);
    }

    /**
     * Contains the URL of an information page in your
     * online shop which informs your consumer about the different possibilities
     * to get in contact with the merchant of the online shop. Please do not use
     * this URL to link to the shopping basket of your consumer!
     *
     * If you do not use the optional parameter imageUrl the serviceUrl is not
     * used within the Wirecard Checkout and your consumer has no possibility to
     * access your service page in your online shop.
     *
     * Additionally some payment methods are using this serviceUrl and require a
     * properly set information page, therefore this parameter is also useful
     * for Wirecard Checkout Seamless.
     *
     * @return string
     */
    public function GetServiceUrl()
    {
        return $this->Get('serviceUrl');
    }

    /**
     * REQUIRED.
     * Contains the URL of an information page in your
     * online shop which informs your consumer about the different possibilities
     * to get in contact with the merchant of the online shop. Please do not use
     * this URL to link to the shopping basket of your consumer!
     *
     * If you do not use the optional parameter imageUrl the serviceUrl is not
     * used within the Wirecard Checkout and your consumer has no possibility to
     * access your service page in your online shop.
     *
     * Additionally some payment methods are using this serviceUrl and require a
     * properly set information page, therefore this parameter is also useful
     * for Wirecard Checkout Seamless.
     *
     * @param string $value Alphanumeric with special characters.
     */
    public function SetServiceUrl($value)
    {
        $this->Set('serviceUrl', $value);
    }

    /**
     * Contains the URL of your online shop used by the
     * Wirecard Checkout Platform to send to your online shop some return values
     * containing the result of the checkout process.
     *
     * For the consumer of your online shop this URL is not a visible page. The
     * URL is used as an entry-point for a server-to-server communication from
     * the Wirecard Checkout Platform to your online shop to inform your system
     * about the result of the payment.
     *
     * @return string
     */
    public function GetConfirmUrl()
    {
        return $this->Get('confirmUrl');
    }

    /**
     * REQUIRED. Contains the URL of your online shop used by the
     * Wirecard Checkout Platform to send to your online shop some return values
     * containing the result of the checkout process.
     *
     * For the consumer of your online shop this URL is not a visible page. The
     * URL is used as an entry-point for a server-to-server communication from
     * the Wirecard Checkout Platform to your online shop to inform your system
     * about the result of the payment.
     *
     * This URL has to be accessible over the internet via port 80 (for http
     * communication) or port 443 (for https communication) and may not be
     * hosted on a local server which cannot be accessed by the Wirecard
     * Checkout Platform via the Internet.
     *
     * Please also ensure that your firewall configurations allow us to send you
     * the confirmation via: 193.110.30.149 or 193.110.30.150
     *
     * @param string $value Alphanumeric with special characters.
     */
    public function SetConfirmUrl($value)
    {
        $this->Set('confirmUrl', $value);
    }

    /**
     * IP address of consumer.
     * @return string
     */
    public function GetConsumerIpAddress()
    {
        return $this->Get('consumerIpAddress');
    }

    /**
     * REQUIRED. IP address of consumer.
     * @param string $value Numeric with special characters.
     */
    public function SetConsumerIpAddress($value)
    {
        $this->Set('consumerIpAddress', $value);
    }

    /**
     * User-agent of browser of consumer.
     * @return string
     */
    public function GetConsumerUserAgent()
    {
        return $this->Get('consumerUserAgent');
    }

    /**
     * REQUIRED. User-agent of browser of consumer.
     * @param string $value Alphanumeric with special characters.
     */
    public function SetConsumerUserAgent($value)
    {
        $this->Set('consumerUserAgent', $value);
    }

    /**
     * Is used in conjunction with the
     * parameter paymentType, when a specific payment method is selected by your
     * consumer in your online shop.
     *
     * @return string
     */
    public function GetFinancialInstitution()
    {
        return $this->Get('financialInstitution');
    }

    /**
     * OPTIONAL. Is used in conjunction with the
     * parameter paymentType, when a specific payment method is selected by your
     * consumer in your online shop.
     *
     * @param string $value This parameter contains one or more financial
     * institutions which you want to offer to your consumer based on the
     * selected payment method. The value is a comma-separated list of shortcuts
     * @see https://integration.wirecard.at/doku.php/request_parameters#financialinstitution
     */
    public function SetFinancialInstitution($value)
    {
        $this->Set('financialInstitution', $value);
    }

    /**
     * The parameter pendingUrl contains the URL of your online shop where your
     * consumer is forwarded when the checkout process could not determine a
     * result yet. On this page of your online shop you should inform your
     * consumer about the pending situation of the checkout process.
     *
     * @return string
     */
    public function GetPendingUrl()
    {
        return $this->Get('pendingUrl');
    }

    /**
     * OPTIONAL.
     * The parameter pendingUrl contains the URL of your online shop where your
     * consumer is forwarded when the checkout process could not determine a
     * result yet. On this page of your online shop you should inform your
     * consumer about the pending situation of the checkout process.
     *
     * When using the optional parameter pendingUrl, the use of the parameter
     * confirmUrl is mandatory.
     *
     * @param string $value Alphanumeric with special characters.
     */
    public function SetPendingUrl($value)
    {
        $this->Set('pendingUrl', $value);
    }

    /**
     * The parameter noScriptInfoURL contains the URL to an information page of
     * your online shop which is displayed to your consumer if the web browser
     * of your consumer has Javascript disabled.
     * @return string
     */
    public function GetNoScriptInfoUrl()
    {
        return $this->Get('noScriptInfoUrl');
    }

    /**
     * OPTIONAL.
     * The parameter noScriptInfoURL contains the URL to an information page of
     * your online shop which is displayed to your consumer if the web browser
     * of your consumer has Javascript disabled.
     *
     * @param string $value Alphanumeric with special characters.
     */
    public function SetNoScriptInfoUrl($value)
    {
        $this->Set('noScriptInfoUrl', $value);
    }

    /**
     * The parameter orderNumber contains a unique ID for the order. If the
     * value of this parameter is set it is not possible that your consumer uses
     * that order number a second time, even if your consumer could not
     * successful finalize the checkout process.
     *
     * Therefore this parameter can only be used if the parameter maxRetries is
     * set to 0.
     * @return string
     */
    public function GetOrderNumber()
    {
        return $this->Get('orderNumber');
    }

    /**
     * The parameter orderNumber contains a unique ID for the order. If the
     * value of this parameter is set it is not possible that your consumer uses
     * that order number a second time, even if your consumer could not
     * successful finalize the checkout process.
     *
     * Therefore this parameter can only be used if the parameter maxRetries is
     * set to 0.
     *
     * @param string $value Numeric with a variable length of up to 9.
     */
    public function SetOrderNumber($value)
    {
        $this->Set('orderNumber', $value);
    }

    /**
     * The parameter windowName contains the name of the pop-up window or iframe
     * where the Wirecard Checkout is opened.
     * @return string
     */
    public function GetWindowName()
    {
        return $this->Get('windowName');
    }

    /**
     * OPTIONAL.
     * The parameter windowName contains the name of the pop-up window or iframe
     * where the Wirecard Checkout is opened.
     *
     * This parameter is required if you offer payment methods which are opening
     * an additional pop-up window like eps online transfer or 3-D Secure. It
     * ensures a proper return to the Wirecard Checkout after that payment
     * method specific pop-up window is closed.
     *
     * @param string $value <ul>
     *                      <li>It must not contain any empty characters.</li>
     *                      <li>It must consist only of letters and numbers and
     *                          the first character has to be a letter.</li>
     *                      <li>Uppercase and lowercase letters are permitted.
     *                          </li>
     *                      <li>A distinction is made between uppercase and
     *                          lowercase letters.</li>
     *                      <li>It must not contain any special or foreign
     *                          characters.</li>
     *                      <li>The only permitted special character is the
     *                          underscore (“_”).</li>
     *                      <li>The window name must not be identical to a
     *                          reserved word in Javascript.</li></ul>
     *  @see http://en.wikibooks.org/wiki/JavaScript/Reserved_Words
     */
    public function SetWindowName($value)
    {
        $this->Set('windowName', $value);
    }

    /**
     * Is used for checking if the same order has been unintentionally sent more
     * than once by your consumer. This is useful to prevent processing of the
     * same order more than once.
     * @return string
     */
    public function GetDuplicateRequestCheck()
    {
        return $this->Get('duplicateRequestCheck');
    }

    /**
     * OPTIONAL.
     * Is used for checking if the same order has been unintentionally sent more
     * than once by your consumer. This is useful to prevent processing of the
     * same order more than once.
     *
     * @param string $value Boolean (“yes” or “no”).
     */
    public function SetDuplicateRequestCheck($value)
    {
        $this->Set('duplicateRequestCheck', $value);
    }

    /**
     * Contains a text which is displayed on the invoice of financial
     * institution of your consumer.
     * @return string
     */
    public function GetCustomerStatement()
    {
        return $this->Get('customerStatement');
    }

    /**
     * OPTIONAL.
     * Contains a text which is displayed on the invoice of financial
     * institution of your consumer.
     *
     * Please note that the appearance of this text and also the allowed set of
     * characters and the length of the text depends on the financial
     * institution.
     * @param string $value Alphanumeric with up to 254 characters, but may
     *                      differ for specific payment methods.
     */
    public function SetCustomerStatement($value)
    {
        $this->Set('customerStatement', $value);
    }

    /**
     * Contains a unique transaction ID which will be forwarded to the financial
     * institution.

     * @return string
     */
    public function GetOrderReference()
    {
        return $this->Get('orderReference');
    }

    /**
     * OPTIONAL.
     * Contains a unique transaction ID which will be forwarded to the financial
     * institution.
     *
     * Please be aware that the set of allowed characters and the allowed
     * maximum length depends on the payment methods and the corresponding
     * financial service providers.
     *
     * @see https://integration.wirecard.at/doku.php/payment_methods:start
     * @param string $value Alphanumeric with up to 128 characters, but may
     *                      differ for specific payment methods.
     */
    public function SetOrderReference($value)
    {
        $this->Set('orderReference', $value);
    }

    /**
     * Allows merchants to define whether a transaction is a single (one-off)
     * transaction or an initial transaction followed by many subsequent ones
     * (e.g. for subscription models).
     * @return string
     */
    public function GetTransactionIdentifier()
    {
        return $this->Get('transactionIdentifier');
    }

    /**
     * OPTIONAL.
     * Allows merchants to define whether a transaction is a single (one-off)
     * transaction or an initial transaction followed by many subsequent ones
     * (e.g. for subscription models).
     *
     * @param string $value SINGLE for one-off transactions and INITIAL for the
     *                      first transaction of a series of recurring payments.
     */
    public function SetTransactionIdentifier($value)
    {
        $this->Set('transactionIdentifier', $value);
    }

    /**
     * A unique reference to a specific order of a specific consumer within your
     * online shop. This orderIdent is used within the Wirecard data storage
     * together with the customerId, shopId and storageId that only you are able
     * to access the specific session of the Wirecard data storage.
     * @return string
     */
    public function GetOrderIdent()
    {
        return $this->Get('orderIdent');
    }

    /**
     * OPTIONAL.
     * A unique reference to a specific order of a specific consumer within your
     * online shop. This orderIdent is used within the Wirecard data storage
     * together with the customerId, shopId and storageId that only you are able
     * to access the specific session of the Wirecard data storage.
     *
     * Please be aware that the value of the orderIdent has to be unique for
     * each order of your consumer.
     *
     * You have to use the same value of the orderIdent for initializing the
     * Wirecard data storage and for initiating the checkout process.
     * @param string $value Alphanumeric with special characters.
     */
    public function SetOrderIdent($value)
    {
        $this->Set('orderIdent', $value);
    }

    /**
     * Is the unique ID to the Wirecard data storage of a specific consumer
     * within a specific checkout process. The storageId is valid for 30 minutes
     * after the latest use of an intitialization, store or read operation on
     * that data storage.
     * @return string
     */
    public function GetStorageId()
    {
        return $this->Get('storageId');
    }

    /**
     * OPTIONAL.
     * Is the unique ID to the Wirecard data storage of a specific consumer
     * within a specific checkout process. The storageId is valid for 30 minutes
     * after the latest use of an intitialization, store or read operation on
     * that data storage.
     *
     * Please be aware that a storageId gets invalid after a successful
     * initiation of the checkout process.
     * @param string $value Alphanumeric with a fixed length of 32.
     */
    public function SetStorageId($value)
    {
        $this->Set('storageId', $value);
    }

    /**
     *
     * @param type $secret
     * @return FrontendInitResponse
     */
    public function Send($secret)
    {
        $response = new FrontendInitResponse();
        $response->InitFromCurlResponse(parent::Send($secret));
        return $response;
    }

}
