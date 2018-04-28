# Ignitiondeck-Add-on
Plugin to introduce some additional fields to the default campaign creation form of <a href="https://wordpress.org/plugins/ignitiondeck/">IgnitionDeck</a>

# Requirements
This will require that 'IgnitionDeck Crowdfunding' is enabled on the site, which I guess requires that you have <a href="https://ignitiondeck.com/id/ignitiondeck-enterprise-white-label-crowdfunding/">IgnitionDeck Enterprise Suite</a> active.

# Description
The default 'Campaign' creation form provided by IgnitionDeck has quite a lot of fields. But once in a while you may require to add some additional fields to suit your project/website.
For example, you may want to add a 'Project Location' field.

Unfortunately, IgnitionDeck does not provide a way to do so using the admin dashboard. Further, it's documentation too, does not give any instructions to do it through the code either.
It took a lot of efforts to go through the Igntiondeck codebase to figure out how to add the field to the frontend as well as the backend, and more importantly how to save the field value.

I have put up the code required to add a new field 'SAMPLE TEXT FIELD', in the form of this plugin. The new field will be added just below the "Project FAQs" field.

You may want to edit the plugin to replace 'SAMPLE TEXT FIELD' wth a more appropriate name, before activating.
 You will want to make these replacements:
 1. Replace 'Sample Text Field' with 'The Label Of Your New FIeld'
 2. Replace 'ign_shkid_sample_text' with 'ign_your_field_name'
 3. Replace 'shkid_sample_text' with 'your_field_name'
 4. Optionally, replace <code>if($form_field['id'] == 'project_faq')</code> with <code>if($form_field['id'] == '<FIELD_ID>')</code>
 where FIELD_ID is the id of the field below which you want the new field to appear.

Some valid values for FIELD_ID are: 
a) project_long_description 
b) project_short_description
c) project_video
d) project_name

You can use 'Inspect Element' to get the id of a field to be used here.

# Installation
Install it, like you would install any other WordPress plugin.
Once activated the new field 'SAMPLE TEXT FIELD' will be visible on the frontend (Dashboard->Create/Edit Project) as well as backend (WP Admin->Projects add/edit screen).
