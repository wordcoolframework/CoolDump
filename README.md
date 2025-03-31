# CoolDump

CoolDump is a tool for beautifully and understandably displaying data in both web and CLI environments. This class enables rendering arrays, objects, and various values in both environments (browser and terminal).

## 📦 Installation & Usage

### Installation

To use CoolDump, first add it to your project:

```sh
composer require cooldump/cooldump
```

### Usage in Project

```php
use CoolDump\CoolDump;

$debugger = new CoolDump();
$debugger->wc(["name" => "Arash narimani", "age" => 23]);
```

## 🚀 Main Functions

### `wc(...$data)`

Displays data in either a web or CLI environment and stops script execution.

```php
wc(["name" => "Arash narimani", "age" => 23]);
```

### `wcJson(...$data)`

Displays data in JSON output.

```php
wcJson(["name" => "Arash narimani", "age" => 23]);
```

## 🎯 Features

✅ Automatic execution environment detection (CLI or web)  
✅ Categorized data display  
✅ Support for various data types  
✅ Debug information including:
- ⏳ Execution time
- 📌 Memory usage
- 🔍 Code snippet from the execution location

## 🔧 Implementation Details

### `renderHtml($data, $level)`

Processes data as HTML for browser display.

### `renderCli($data, $level)`

Processes data as text for terminal display.

### `getCodeSnippet($file, $line, $padding = 5)`

Extracts and displays the code snippet related to the `wc` execution location.

### `getFunQuote()`

Returns a random quote about programming and debugging.

## 🛠 Helper Functions

### `isWeb()`

Checks whether the script is running in a web or CLI environment.

### `getType($value)`

Determines the data type.

## 🌍 Global Helper Functions

`wc()` and `wcJson()` are globally defined helper functions that can be used anywhere in the project without instantiating a class.

---

🚀 **CoolDump** – A better and faster debugging tool! 🎯
