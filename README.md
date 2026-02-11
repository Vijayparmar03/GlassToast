# GlassToast – Modern 3D Toast Notification Library

GlassToast is a lightweight, modern, and beautiful toast notification library with 3D glass effects and smooth animations.

---

## ✨ Features

- Modern glassmorphism UI  
- 3D animated toasts  
- Success, Error, Info, Warning types  
- Confirmation dialog support  
- Auto-hide with progress bar  
- Pause on hover  
- Click to close  
- No dependencies (except Font Awesome for icons)  
- Easy CDN integration  

---

## 🚀 Installation (Using CDN)

You can use GlassToast directly in your project without downloading anything.

### Example of How to Add CDN

```html
<!DOCTYPE html>
<html>
<head>

    <!-- STEP 1: Font Awesome CDN (Required for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- STEP 2: GlassToast CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Vijayparmar03/GlassToast@main/vijay.css">

</head>

<body>

    <!-- Your website content -->

    <!-- STEP 3: GlassToast JS -->
    <script src="https://cdn.jsdelivr.net/gh/Vijayparmar03/GlassToast@main/vijay.js"></script>

</body>
</html>

Example of class
   1 GlassToast.success("Success", "Data saved successfully!");
   2 GlassToast.error("Error", "Something went wrong!");
   3 GlassToast.info("Info", "New update available.");
   4 GlassToast.warning("Warning", "Please fill all fields.");
   5 GlassToast.confirm("Delete User", "Are you sure?", function() {
      // Code to execute on confirm
      console.log("User confirmed!");
    });
    
  6 => You can customize toast duration (in milliseconds):
  GlassToast.success("Saved", "Record saved!", 8000);




    
