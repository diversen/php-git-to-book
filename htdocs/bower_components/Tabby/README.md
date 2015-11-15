# Tabby

This jQuery plugin is by Ted Devito, originally found at  [http://teddevito.com/demos/textarea.html][ted].

_(Update: His website is gone now, but [the Internet Archive has a copy][ted], and remarkably, I also had the foresight to include the original page within this repository before his site disappeared.)_

There did not seem to be a GitHub repo for it yet, so I made one.

This is also an npm module, available as `jquery-tabby`.

### Purpose

Ted:

> The "Tabby" Javascript jQuery plugin … [allows use of the Tab key] in regular `textarea`s to make them suitable for in-browser coding [in] languages like HTML, CSS, Javascript, or your favorite server-side language. The idea is to be able to use a press of the TAB button or SHIFT+TAB to indent or outdent your code.

It works pretty well for Markdown editors, too.

### Usage

Can’t be any simpler:

```js
	$('.my-textarea').tabby();
```

To use e.g. four spaces instead of the default tab character:

```js
	var tabby_opts = {tabString:'    '};
	$('.my-textarea').tabby(tabby_opts);
```

### Demo

Please see [Ted’s demo here][ted].

### Differences from original

I made a small change to better support alternate tag strings besides the actual tab character `\t` (e.g. four spaces).

Kind contributors have also provided patches here on GitHub, such as better `window.setTimeout` calls.

### Caveats / Issues

1. Outdenting will not work if there are (hard) tab characters used but `tabby` was initialized with a number of spaces as the `tabString` (i.e. soft tabs), and vice-versa.  You should probably standardize input to your preferred tab string (soft or hard tabs) before presenting a Tabby-enabled `textarea` to your users.

2. Sometimes the selection can change slightly (e.g. grow to include a previous line) when outdenting. Pull requests are welcome!

### Bookmarklet

[Grab the bookmarklet here](http://alanhogan.com/bookmarklets#tabby).

### See Also

For a description of the problem and how this solution is implemented, please see [Ted’s original description][ted].

[ted]: http://web.archive.org/web/20110716201510/http://teddevito.com/demos/textarea.html "Original website and demo (via Internet Archive)"
