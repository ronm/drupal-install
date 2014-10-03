About
=====

This adds a new display style to views called "Slick carousel". Similar to how
you select "HTML List" or "Unformatted List" as display styles.

This module doesn't require Views UI to be enabled but it is required if you
want to configure your Views display using Slick carousel through the web
interface. This ensures you can leave Views UI off once everything is setup.

Optionsets
==========

Arm yourself with proper optionsets. To create one, go to:

"admin/config/media/slick"

Usage
=====
Go to Views UI "admin/structure/views", add a new view, and a block.

Usage #1
--------
Displaying multiple (rendered) entities for the slides.
- Choose "Slick carousel" under the Format.
- Choose "Rendered entity" or "Content" under "Show" under "Format", and its
  View mode.

Themeing is related to their own entity display outside the Views UI.
Example use case: Blogs, teams, testimonials, case studies sliders.

Usage #2
--------
Displaying multiple entities using selective fields for the slides.
- Choose "Slick carousel" under the Format.
- Choose available optionsets you have created at "admin/config/media/slick"
- Choose "Fields" under "Show" under "Format".
- Add fields, and do custom works or markups. If having a multi-value Image
  field, recommended to only display 1.

Themeing is all yours inside the Views UI.

Example use case: similar as above.

Usage #3
--------
Displaying a single multiple-value field in a single entity display for the
slides. Use it either with contextual filter by NID, or filter criteria by NID.
- Under Pager", choose "Display a specified number of items" with "1 item".
- Choose "Unformatted list" under the Format.
- Add a multi-value Image, Media or Field collection field.
- Click the field under the Fields, choose "Slick carousel" under Formatter.
- Adjust the settings.
- Make sure to Display "all" or any number > 1 under "Multiple Field settings".
- Check "Use field template" under "Style settings", otherwise no field visible.

Themeing is mostly taken care of by slick_fields.module in terms of layout, with
the goodness of Views to provide better markups manually.

Example use case: front or inner individual slideshow based on the entity ID.

Gotchas:
=======
If you are choosing a single multi-value field (such as images, media files, or
field collection fields) rather displaying various fields from multiple nodes,
make sure to:
- Choose a "Unformatted list" Format, not "Slick carousel".
- Choose "Slick carousel" for the field when configuring the field instead.
- Check "Use field template" under "Style Settings"so that the Slick field
  themeing is picked-up.
