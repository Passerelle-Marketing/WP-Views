# WP Views

This is a toolkit for building Wordpress themes and plugins that seperates buisiness logic and data manipulation from templates. As best as can be accomplished within Wordpress it avoids stateful functions and global variables, and makes it possible to entirely forgo The Loop. It provides exensible ViewModels in order to create a singular set of methods for accessing content within the templates, whether that content comes from the WP core, plugins, or third party services.

## Installation

This was built to be installed as a [Composer](https://getcomposer.org) dependency.

## Usage

### Setup

In order to extend WP Views' classes, a parallel set of classes must be created in your plugin or theme, using the same names but a unique [namespace](https://secure.php.net/manual/en/language.namespaces.php). Factory classes and the `ExternalObject` class should not be duplicated, but all other classes should be duplicated if you wish to use them in your project. Your `Base` class should extend `DaveJToews\WPViews\ExternalObject`, and all other classes should have an inheritance structure which parallels the structure wthin WP Views. E.g. your `View` class should extend your `Base` class just as WP Views `View` class extends WP Views `Base` class. Thus all of your classes will in turn inherit from `ExternalObject`.

`ExternalObject` contains magic methods that will allow method calls within your templates to access methods within WP Views or within your own classes. No methods need to be defined for your own classes, unless you wish to override a method from WP Views or add a new method.

### Templates

Each template should include the following code:

    $site = new YourUniqueNamespace\Site();
    $view = DaveJToews\WPViews\ViewFactory::create('YourUniqueNamespace');
    $state = new YourUniqueNamespace\State();

`YourUniqueNamespace` should of couse be replaced with your unique namespace. The View Factory will return the appropriate view class for the current view. The `Site` class will contain all methods for accessing global site content. The `State` class will contain methods for accessing stateful data which are not appropriate to include in view classes.

### Classes

#### View Classes

For any given page load a View class can automatically be generated using the `ViewFactory` as shown above. All View classes except `Error404` can also be instantiated outside of that particular view in order to access the content and fields available through that classes methods.

##### Page Template Views

The class `PostPage` is the base class for all pages. (Except for the Posts page, which in WP Views is treated as an archive rather than a page.) A static front page will use the class `PostPageFront`. Any non-default page template should be created with a filename begining with "template-". A new class should be created for use with this template. What comes after "template-" and before ".php" in the template filename, should be stripped of non-alphabetic characters and [PascalCased](http://wiki.c2.com/?PascalCase) for your class name. Thus a template file of "template-foo-bar.php" should go with a class named `PostPageFooBar`.

##### Post Type Views

The class `Post` is the base class for all posts, including Wordpress's default blog Posts and Pages, and any custom post types. Wordpress's default "post" type will use the class `PostBlog`. Pages will use `PostPage`. If a custom post type of "foo" is created you will need to create a class called `PostFoo` which will exted your `Post` class. If your post type has dashes or other non-alphabetic characters separating words, these characters should be stripped and the words should be [PascalCased](http://wiki.c2.com/?PascalCase) for your class name. Thus a post type of "foo-bar" should use the class `PostFooBar`.

If your custom post type has an archive an additional class will need to be created for the archive view. See below.

##### Archive Views

The class `Archive` is the base class for all archives including the archive for Wordpress's default post type, even when there is a static front page and the post archive is on a page. That default "post" type will make use of the class `ArchiveBlog`. The archive for a custom post type called "foo-bar" will use the class `ArchiveFooBar`. Non alphabetic characters should be stripped and the words should be [PascalCased](http://wiki.c2.com/?PascalCase).

##### Term Views

The class `Term` is the base class for all terms. The default category, tag, and post format taxonomies use the classes `TermCategory`, `TermTag`, and `TermPostFormat`. Additional classes will need to be created for any custom taxonomies. A taxonomy of "foo-bar" will need a class called `TermFooBar`. Non alphabetic characters should be stripped and the words should be [PascalCased](http://wiki.c2.com/?PascalCase).

##### Date, Error404 and Search Views

Year, month, and day queries all make use of the `Date` class. Error404 pages use the `Error404` class. Search queries use the `Search` class.

#### SubSections

The `SubSection` class exists to break up other classes into subsections. Subsection classes can be created to group methods, parallel template partials, avoid large and messy view classes, and allow Subsections to be shared by different view types. Every unique SubSection should be defined by a unique class, e.g. `SubSectionFoo`. 

Arguments can be passed to a SubSection in order to refer back to the view class in which it was instantiated, or to pass data into. Argument #1 should be the ID of this parent view, or some other means of referring back to it. This functionality was created with [Advanced Custom Fields](https://www.advancedcustomfields.com) repeater fields in mind. Using ACF's `get_field()` function for a repeater field returns a nested array of repeating fields and their sub-fields. The array of subfields can be passed as argument #2, when instantiating a SubSection. This can be facilitated by making use of the method `get_subsections_from_acf_repeater` found in `Base.php`.

An optional third parameter can be used to pass a field prefix. This is useful when it is necessary to use the same layout block with *different* ACF fields. This requires enforcing a strict naming scheme in your ACF fields. My primary use for this is when using options pages to create fields for various custom post type archives. Since there is no post ID attached to these fields, they need to be distinguished with a field prefix. This way I can write a SubSection that effectively fetches both `foo_archive_heading` and `bar_archive_heading`, with the same method in different contexts. 

#### Site Object

The site class, which should be instantiated in all templates is the place to put methods to access content or data that is not attached to a particular view and may need to be accessed within many or all views. E.g. header and footer content.

#### State Object

The state class, like the site class should be instantiated in all templates. This is the place for methods to access content that may be contigent on something other than a post ID. Specifically, this class was created to deal with pagination.

### Methods

Within templates most content will be accessed using two methods defined in the `Base` class: `get()`, and `put()`. Each of these takes a single argument: a string naming the field/content block being fetched. `get()` returns the value while `put()` returns it.

Additional methods include:

    * `has()`: for returning booleans.
    * `get_set()`: for returning arrays. To distinguish directly returning content from returning sets of content. 
    * `get_with()`: for returning values that are contingent upon data passed in. Such as in recursive functions. Created for use in breadcrumb.
    * `get_image()`: for returning image markup, with configuration arguments. Should make use of `get_image_markup()`.
    * `put_image()`: prints image markup.

#### 

#### `get`
#### `put`

#### `get_image`

### ACF

## What's missing

### Comments
