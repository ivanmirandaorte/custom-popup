# Pro Child Theme

A child theme for the Pro theme.

## About Child Themes

A child theme is a theme that inherits the functionality of another theme, called the parent theme. Child themes are the recommended way to modify a theme's code. Instead of modifying the Pro theme directly, all modifications should be made in this child theme.

## File Structure

- **style.css** - Child theme stylesheet. Add your custom CSS here.
- **functions.php** - For adding custom functions and hooks without modifying the parent theme.
- **languages/** - For translations and localization files.

## How to Customize

### CSS Customizations

Add any custom CSS to the bottom of `style.css`. The parent theme's CSS will load first, allowing you to override styles as needed.

### Function/Hook Customizations

Add any custom functions and PHP code to `functions.php`. This is the best place to add custom hooks and filters without modifying the parent theme.

### Template Customizations

If you need to override a template file from the parent theme, simply copy it to this child theme directory, maintaining the same directory structure. For example:

- `header.php` - Custom header template
- `footer.php` - Custom footer template
- `template-parts/` - Custom template parts

## Activating the Child Theme

1. Go to WordPress Admin Dashboard
2. Navigate to **Appearance > Themes**
3. Look for "Pro Child" and click **Activate**

## Important Notes

- Do NOT modify files in the parent Pro theme directory
- All customizations should be made in this child theme
- When the Pro theme is updated, your customizations will remain safe in the child theme
- Always test your changes thoroughly

## Resources

- [WordPress Child Themes Documentation](https://developer.wordpress.org/themes/advanced-topics/child-themes/)
- [Pro Theme Documentation](https://theme.co/pro)
