# Slim API Template

A robust and feature-rich API template built with PHP Slim Framework, providing ready-to-use implementations for weather data, QR code generation, and more.

## Features

- 🚀 Built with Slim 4 Framework
- 🌤️ Weather API Integration with OpenWeatherMap
- 📱 QR Code Generation API
- 🔐 Proper Error Handling
- 📁 Well-organized Project Structure
- 🛠️ Easy to Extend and Customize

## Project Structure

```plaintext
api-project/
├── composer.json
├── .htaccess
├── public/
│   ├── index.php
│   └── .htaccess
├── src/
│   ├── Config/
│   │   └── settings.php
│   ├── Controllers/
│   │   ├── HelloController.php
│   │   ├── WeatherController.php
│   │   └── QRCodeController.php
│   ├── Routes/
│   │   └── api.php
│   └── bootstrap.php
└── vendor/
```

## Requirements

- PHP >= 7.4
- Composer
- Apache/Nginx Web Server
- GD extension (for QR code generation)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/1dev-hridoy/SlimApiTemplate.git
```

2. Install dependencies:
```bash
composer install
```

3. Configure your web server to point to the `public` directory

4. Copy `.htaccess` files to their respective locations

## Available APIs

### 1. Hello World Endpoint
```http
GET /api/hello
```

### 2. Weather API Endpoints
```http
# Get current weather
GET /api/weather?city={cityName}

# Get weather forecast
GET /api/weather/forecast?city={cityName}
```

Parameters:
- `city`: Name of the city (required)

### 3. QR Code Generation Endpoints
```http
# Generate QR code as image
GET /api/qr/generate?text={text}&size={size}&label={label}

# Generate QR code as base64
GET /api/qr/base64?text={text}
```

Parameters:
- `text`: Content to encode in QR code (required)
- `size`: Size of QR code in pixels (optional, default: 300)
- `label`: Text label below QR code (optional)

## Example Usage

### Weather API
```javascript
fetch('http://your-domain/api/weather?city=London')
  .then(response => response.json())
  .then(data => console.log(data));
```

### QR Code Generation
```html
<!-- Display QR code directly -->
<img src="http://your-domain/api/qr/generate?text=Hello World" alt="QR Code">

<!-- With custom size -->
<img src="http://your-domain/api/qr/generate?text=Hello World&size=200" alt="QR Code">
```

## Configuration

### Weather API
Update the OpenWeather API key in `src/Controllers/WeatherController.php`:
```php
private $apiKey = 'your-api-key';
```

## Contributing

1. Fork the repository
2. Create a new branch (`git checkout -b feature/improvement`)
3. Commit your changes (`git commit -am 'Add new feature'`)
4. Push to the branch (`git push origin feature/improvement`)
5. Create a Pull Request

## Author

- **Hridoy** - [GitHub Profile](https://github.com/1dev-hridoy)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

## Support

If you find this template helpful, please consider giving it a ⭐️ on GitHub!

## Last Updated

2025-03-29 17:26:17 UTC by @hridoy09bg