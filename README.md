![cover](https://www.snipi.sk/storage/app/media/projekty/pluginy/cover.jpg)

Are u sick from searching images, downloading and reuploading? Here is a light solution for creating all from one place.

# Installation
For install this plugin you can use Plugin installation tool in octobercms backend, where type 
```
SNiPI.UniqueMediaFinder
```
## First steps
To allow search you need to create an applications in unsplash.com or pexels.com, where you can obtain api keys. This api keys is provided in plugin settings.

## Search for stock photos in Unsplash or Pexels
For current most popular stock databases is used Unsplash and Pexels integration. Then you are able to obtain api keys for both and use both APIs for searching and downloading pictures.

## Feature
This is currently quick extension, but i will provide more features for this, like informations, loading collections from current author, searching by multiple parameters like photo ortientation etc.

### Bug reporting
Please, if you find some issues or have any ideas, please, provide feedback at snipi[at]snipi[dot]sk

## Installation
For install this plugin you can use Plugin installation tool in octobercms backend, where type SNiPI.UniqueMediaFinder

## First steps
To allow search you need to create an applications in unsplash.com or pexels.com, where you can obtain api keys. This api keys is provided in plugin settings.

## Searching
This plugin creates new section in media library called **Search providers** (located after filters in left side). Each search provider is clickable, then when you navigate to provider,
first click switches *media browser* to **searching** on selected provider. In first version of this plugin, search was performed over each provider, which creates unwanted requests, then,
when you want to search on other providers, simply click to another provider. This will automatically call last search query, if is filled. When search query is empty, first load from provider contains latest or random pictures, regarding what provider offers.

## Downloading
There are a two options how to download picture from search results. First, when you move cursor over preview, you can see two buttons. First is for show detailed informations, second for download. In details popup you can find button for download too, and this is second opinion how to download pictures. After successfull download, you are asked, if you want to navigate to folder, where photo was downloaded. If you cancel that confirmation, you can continue in browsing search results.

## Metadata informations
When you wish to provide **sourcing** of photo, then probably you will get a simple way how to show that without copy+paste name or provider informations, right? When you allow to store metadata for downloaded files, then you can use component for showing media info, which belongs to specific file. Component is fully configurable and comes with simple styling for better looking "source". Part of stored data was search requests for dashboard widgets statistics. 

## Dashboard widgets
There are two main widgets. First, with providers limits and remaining api requests rate. Second is for statistics purpose, where you can see, what is most searched and which provider is most common used.

## Known limitations
Many of limitations is based on specific provider. Please, see table bellow.

Provider | Limit per hour | Limit per month
------------|--------------------|--------------
Unsplash | 50 (demo) 5000 (verified) | -
Pexels | 200 | 20000 
Pixabay | 5000 | -

### Unsplash verification
When u will get 5000 request per hour limit, you need to send your application for verification with screenshots, etc. Here i will probably talk more with unsplash api team, to get specific allowance for this plugin.

### Pexels
You are able to send mail to api@pexels.com to get more rate limit.

### Pixabay
Here is probably good way to get many photos, but, here is other limitation - maximum quality of image. In basic api requests you can get pictures with maximum 1280 px large size. For full HD images you need to send apply for full api access.

---

[![Buymeacoffee.com](https://www.snipi.sk/storage/app/media/bmc-full-logo-no-background.png)](https://www.buymeacoffee.com/snipiba)