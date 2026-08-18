# About

This directory will contain scripts for performing queries of the PayPal Rest API for creating orders (membership renewals) and confirming those orders, with the goal of automating the membership renewals.


## Testing the PayPal API

- create client app client ID and secret at  https://developer.paypal.com/dashboard/applications/sandbox

### Exchange client app client ID and secret for an access token

To create an order using your PayPal client ID and secret, you must first exchange those credentials for an OAuth 2.0 access token and then use that token to call the Orders API. 

1. Get an Access Token 
Exchange your client ID and secret for a temporary access token by sending a POST request to the PayPal OAuth endpoint. 
Endpoint: https://api-m.sandbox.paypal.com/v1/oauth2/token (use api-m.paypal.com for live).
Method: POST.
Authentication: pass the following in the Body of the Post message (Username = Client ID, Password = Secret).
Body: grant_type=client_credentials (x-www-form-urlencoded)


## Initial ideas for using the PayPal API (May 24, 2026)

Looking into running PayPal API requests (https://developer.paypal.com/api/rest/) from PostMan; we probably want to use the API to ‘create order with minimal request’ and then probably ‘show order details’ to confirm.

To test the order creation I posted to `{{base_url}}/v2/checkout/orders?userSession=sessionValue345abc` using `userSession` as an ID we would use to query the database for a user session (maybe an encoded email address like we use for email address verification) so when we redirect back to the app from PayPal the app knows who to the PalPal request belongs to. An example of a PayPal order request looks like:

```
{
    "id": "0ND3979258551070T",
    "intent": "CAPTURE",
    "status": "CREATED",
    "purchase_units": [
        {
            "reference_id": "default",
            "amount": {
                "currency_code": "USD",
                "value": "100.00"
            },
            "payee": {
                "email_address": "john_merchant@example.com",
                "merchant_id": "C7CYMKZDG8D6E"
            }
        }
    ],
    "create_time": "2026-05-24T13:51:02Z",
    "links": [
        {
            "href": "https://api.sandbox.paypal.com/v2/checkout/orders/0ND3979258551070T",
            "rel": "self",
            "method": "GET"
        },
        {
            "href": "https://www.sandbox.paypal.com/checkoutnow?token=0ND3979258551070T",
            "rel": "approve",
            "method": "GET"
        },
        {
            "href": "https://api.sandbox.paypal.com/v2/checkout/orders/0ND3979258551070T",
            "rel": "update",
            "method": "PATCH"
        },
        {
            "href": "https://api.sandbox.paypal.com/v2/checkout/orders/0ND3979258551070T/capture",
            "rel": "capture",
            "method": "POST"
        }
    ]
}
```
