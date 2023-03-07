A plugin that creates a custom "Faculty" Post Type for displaying College Faculty and Staff using a form. Uses Divi Themes blog module and Post Types Order plugin!

## How it works

This Plugin creates a custom post type for Wordpress and gathers data based on custom meta fields. These fields appear as a form labled "Faculty Information" when a user edits, or creates a new Faculty post. The data from the Meta fields form input are written to a HTML template (saved as a string and updated to the post content) when the user "saves" or "updates" a post. The Divi Theme displays these post templates in a Grid form to make "cards".

# Local Wordpress Installation 🌻

- For Mac, follow the installation steps from: [MAMP Installation steps](https://www.wpbeginner.com/wp-tutorials/how-to-install-wordpress-locally-on-mac-using-mamp/)
- [MAMP Download link](https://www.mamp.info/en/downloads/)
- [Download Wordpress for local envrionment](https://wordpress.org/download/)

# Local Wordpress Setup 🌻

## Steps to Setup the Plugin/Other tools 🛠️

1. Add the `Fullerton Faculty Cards` Plugin and Activate it

2. Add the `Post Types Order` Plugin, activate, and configure:

- From the Dashboard, go to Settings Page make the configuration:
  - "Hide" re-order interface for all posts other than "Faculty".
  - "Show" re-order interface for the "Faculty" post type
  - Minimum level to use this plugin - "Editor"
  - Save Settings

When it's done, this should look something like -

![Screenshot 2023-02-21 at 3 07 48 PM](https://user-images.githubusercontent.com/95142863/220458851-cddc7afe-84e4-49a7-9aca-5af54bc2f7e5.png)

3. Activate the `Divi theme` (if not already activated)

4. From the Dashboard, add the following CSS code to Appearance --> Customize --> "Additional CSS"

```
/* Styles to Faculty Cards */
.fc-container {
  width: 100%;
  margin-bottom: 30px;
  background-position: 50%;
  background-repeat: no-repeat;
  float: left;
  position: relative;
  z-index: 2;
  min-height: 1px;
  vertical-align: baseline;
  background: transparent;
  color: #666;
  line-height: 1.7em;
  font-weight: 500;
  border: 1px solid #919090c3;
  padding-top: 0px;
}

.fc-header {
  margin-top: 0px;
  margin-bottom: 30px;
  text-align: left;
  border-color: #9b9b9b #9b9b9b #f1f1f1 #9b9b9b;
  padding-bottom: 0px !important;
  position: relative;
  border: 0 solid #333;
  background-position: 50%;
  background-repeat: no-repeat;
  vertical-align: baseline;
  background: transparent;
}

.fc-header-title {
  font-size: 18px;
  font-family: "Arial", Helvetica, Arial, Lucida, sans-serif;
  color: #0f406b;
  line-height: 1em;
  background-color: #f1f1f1;
  border-color: #9b9b9b #9b9b9b #f1f1f1 #9b9b9b;
  padding-top: 8px !important;
  margin-block-start: 0px;
  margin-block-end: 0px;
  padding-left: 10px !important;
  position: relative;
  border: 0 solid #333;
  letter-spacing: 0.4px;
}

.fc-ht-el {
  margin-block-start: 0px !important;
  margin-block-end: 0px !important;
  font-weight: 100 !important ;
}

p {
  margin-block-start: 0px !important;
  margin-block-end: 0px !important;
}

.fc-content {
  margin-bottom: 0;
  line-height: 1em;
  border-width: 1px;
  border-color: #f1f1f1 #9b9b9b #9b9b9b #9b9b9b;
  height: 300px;
  padding-top: 10px !important;
  margin-top: -30px !important;
  box-shadow: -7px 10px 22px 2px rgb(0 0 0 / 30%);
  word-wrap: break-word;
  position: relative;
  border: 0 solid #333;
  background-size: cover;
  background-position: 50%;
  background-repeat: no-repeat;
  color: #666;
  font-weight: 500;
  text-align: center;
}

.fc-img {
  border: 1px solid #eaeaea;
  border-radius: 8px;
  max-height: 120px;
}

.fc-program {
  font-family: "Arial", Helvetica, Arial, Lucida, sans-serif;
  font-size: 14px;
  line-height: 1em;
  font-weight: 500;
}

.fc-text {
  font-size: 14px;
  font-weight: 100 !important;
}

.fc-link {
  color: #0f406b;
  text-decoration: none;
  font-weight: 600;
  font-size: 14px;
  letter-spacing: 0.4px;
  font-family: "Arial", Helvetica, Arial, Lucida, sans-serif;
}

.faculty .entry-title {
  display: none;
}
```

## Steps to create your Faculty Cards 🛠️

1. Click "Add new" on the Faculty plugin page

2. Fill in the "Faculty Information" form fields

- You can get the Photo URL by going to the "Media" tab --> clicking on the desired image --> then copy the File URL to the clipboard

<p align="center">
<img width="1175" alt="Screenshot 2023-02-17 at 12 50 32 PM" src="https://user-images.githubusercontent.com/95142863/219759075-ff982e5b-5b56-4185-a56e-de71966ebc66.png">
</p>
<p align="center">Photo URL circled in red</p>

<p align="center"><img width="1065" alt="Screenshot 2023-02-16 at 11 24 20 PM" src="https://user-images.githubusercontent.com/95142863/219559415-a782e42a-8117-4563-8d5b-13c78332930b.png"></p>
<p align="center">Example Form Filled out for a Faculty Member</p>

- Note: Add the Title in `last name, first name` format to make sorting by Alphabetical order easier later on

3. Publish the post

   - You'll see post content populate after refreshing the page

4. Create a few more faculty members by repeating steps 1 - 3

5. Reorder the Faculty member Posts in Alphabetical order by drag and drop

<p align="center"><img width="1092" alt="Screenshot 2023-02-16 at 11 52 05 PM" src="https://user-images.githubusercontent.com/95142863/219560711-cb2cf815-4ab5-4946-b2b2-72244bb77257.png"></p>

<p align="center">Posts listed in Alphabetical order A-Z by last name</p>

6. Create a New Page for the Faculty and Staff.

7. In your new page, edit with the Divi Builder, and add the "Blog" Module and configure:

- Content Tab:
  - Content Dropdown: Post Type - Faculty, Content Length - Show Content
  - Elements Dropdown: Set to "No" for all options
- Design Tab:
  - Layout Dropdown: Grid
  - Border Dropdown: Set Grid Layout Border Width to 0px

8. Save the Page

- Note: the Faculty Post Titles will still appear in the Page editor, but will be hidden on the live url

<p align="center"><img width="1163" alt="Screenshot 2023-02-16 at 11 36 02 PM" src="https://user-images.githubusercontent.com/95142863/219560010-d21d1cdb-b494-4189-943a-b513524b82aa.png"></p>

<p align="center">Resulting Grid Cards</p>
