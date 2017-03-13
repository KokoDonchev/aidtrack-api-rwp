# AidTrack Project

AidTrack is RWP from Coventry University

## Information

Information about the project

## API Endpoints

```php
use Restserver\Libraries\REST_Controller;

class V1 extends REST_Controller
{
  public function campaigns_get()
  {
    // Option ID to get one entry
    // Without ID all campaigns are given as response
    // Response structure will come here
  }

  public function campaigns_post()
  {
    // Required fields
    // ....
  }

  public function shipments_get()
  {
    // Option ID to get one entry
    // Without ID all campaigns are given as response
    // Response structure will come here
  }
  public function shipments_post()
  {
    // Required fields
    // ....
  }

  public function products_get()
  {
    // Option ID to get one entry
    // Without ID all campaigns are given as response
    // Response structure will come here
  }
  public function products_post()
  {
    // Required fields
    // ....
  }
}
```