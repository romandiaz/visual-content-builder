# WordPress Visual Content Builder Plugin

## 1. Project Goal

The objective of this project is to create a **visual, drag-and-drop content builder** for WordPress, similar in concept to popular plugins like Elementor or WPBakery. The goal is to empower users to build complex and custom page layouts directly on the front end without needing to write any code.

## 2. Current Status

The project is in the initial setup phase. We have successfully created the foundational pieces of a modern WordPress plugin that uses **React** for its user interface.

Here's what has been built so far:

* **Basic Plugin Structure:** A main plugin file (`visual-content-builder.php`) is in place. It handles the registration of the plugin with WordPress and enqueues the necessary scripts and styles for the editor.
* **React Application:** A basic React application has been created in the `src` directory.
    * It uses the `react-beautiful-dnd` library to demonstrate basic drag-and-drop functionality.
    * The entry point is `src/index.js`, which renders the main `src/App.js` component.
* **Build Process:** A standard Node.js build process using `@wordpress/scripts` is set up. This compiles the modern JavaScript (JSX) from the `src` folder into a browser-compatible `build` folder.
* **Editor Integration:** The main plugin file includes functionality to:
    * Add a "Launch Visual Builder" button to the Gutenberg editor's toolbar.
    * Enqueue the compiled `build/index.js` and `build/index.css` on the post/page edit screens.
    * Add a `div` with the id `visual-builder-root` to the page, which is the mount point for our React application.

**Note on Build Issues:** We encountered some environment-specific issues where the `wp-scripts` command was not found. The solution was to either use `npx wp-scripts build` or, in more stubborn cases, to clear the npm cache (`npm cache clean --force`) and reinstall dependencies (`rm -rf node_modules package-lock.json && npm install`). The `package.json` has been updated to use `npx`.

## 3. File Structure

```
/visual-content-builder
|
├── build/
|   ├── index.js        // The compiled, production-ready JavaScript
|   └── index.css       // The compiled CSS
|
├── node_modules/       // Project dependencies (Not included in final plugin)
|
├── src/
|   ├── App.js          // The main React component
|   ├── index.js        // The entry point for the React app
|   └── index.css       // Styles for the React app
|
├── package.json        // Defines project scripts and dependencies
├── package-lock.json   // Records exact dependency versions
└── visual-content-builder.php // The main WordPress plugin file
```

## 4. How to Continue Development

1.  **Environment Setup:**
    * Ensure you have [Node.js](https://nodejs.org/) and `npm` installed.
    * Navigate to the plugin's root directory (`/wp-content/plugins/visual-content-builder`) in your terminal.
2.  **Install Dependencies:**
    * Run `npm install`. This will install all packages listed in `package.json` into the `node_modules` folder.
    ```sh
    npm install
    ```
3.  **Development Workflow:**
    * Run `npm run start`. This will start a development server that automatically watches for changes in the `src` folder and recompiles the code as you work.
    ```sh
    npm run start
    ```
4.  **Creating a Production Build:**
    * Run `npm run build`. This creates the optimized, production-ready files in the `build` directory. This is the code that will be shipped with the plugin.
    ```sh
    npm run build
    ```

## 5. Immediate Next Steps

1.  **Properly Launch the React App:** The current "Launch Visual Builder" button only triggers an `alert()`. The next step is to modify the JavaScript in `visual-content-builder.php` to properly mount the React application into the `#visual-builder-root` element when the button is clicked, effectively taking over the editor's screen.
2.  **Implement Data Saving:** Once the app is launched, we need to save the layout.
    * Use the WordPress REST API to create a custom endpoint.
    * When the user saves the post/page, send the state of our React components (the array of items, their order, and their content) to this endpoint.
    * The endpoint's PHP function will then save this data as a post meta field using `update_post_meta`.
3.  **Implement Data Loading:** When the editor loads, the React app needs to fetch the saved layout from the REST API and initialize its state with that data, so the user can continue where they left off.
