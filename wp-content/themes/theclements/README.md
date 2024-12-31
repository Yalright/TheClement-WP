# Yalright Starter Theme
---
Custom theme starter by Yalright Digital

The theme uses [Bootstrap](https://getbootstrap.com/) for very minimal styling of the grid but can have extra elements included if easier to use than coding it yourself. Look at `src\scss\main.scss` to see what is included.
---
## Set-up of the theme
#### 1. Download the latest version of WP from [WordPress Codex](https://wordpress.org/download/)
#### 2. Copy across custom theme and plugins to project
#### 3. Install the dev dependencies
`.nvmrc` file mentions the version of node that is recommended for this project. Recommended version `npm 12.0.0` but either 12.0.0 or 14.0.0 would be suitable for this project.
To run the recommeneded version attached to the project type in `nvm use` into the command prompt/terminal.
After this, you'll need to run `npm install` **inside your theme directory** next to install the node modules you'll need for Gulp, etc.
#### 4. Compile JS and SASS Files
`gulp watch` to compile the project