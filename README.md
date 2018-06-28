# University of Hawaiʻi Emergency Alerts WordPress Plugin

Periodically check the UH Alerts API (Application Programming Interface) to automatically display any notifications specific to the selected region.

A region must be selected before the plugin will work.

## Settings

- **Main Settings**
    - **Region** - Fetch alerts for this selected region. The regions are collected from the UH Alerts API.
    - **Refresh Rate** - How often, in seconds, are new alerts checked for?
    - **Display Style** - See below for the built-in styles offered.
- **API Settings**
    - **API Base URL** - The root URL for the UH Alerts API.
    - **Regions Route** - Route from the API Base to grab the regions data. 
    - **Alerts Route** - Route from the API Base to grab the alert data. 
    - **Debug** - Show a debug log in the browser console when checking alerts.

### Display Styles

Because there are a wide variety of WordPress templates in use, so **not all display styles will work with all templates**.

- “Banner” (top)   
  ![alerts show in a banner at the top of the page above other content](assets/banner.svg)
- “Window Shade” (top, overlaid)  
  ![alerts show in a banner at the top of the page over other content](assets/window-shade.svg)
- “Toast” (bottom right, overlaid)  
  ![alerts show in bottom right of page over other content](assets/toast.svg)
- “Modal” (center, overlaid)  
  ![alerts show in the center of the page over other content](assets/modal.svg)

## Not Using WordPress

It is very easy to use the UH Alerts functionality of this [plugin without using WordPress](README-no-wordpress.md).

