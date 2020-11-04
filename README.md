# Little Devil's Nursery Management System
This is a sample project based on a tech test where the concept is to build a management system for a nursery.

The nursery required a system to manage the children that go to their nursery and manage various details about those children.

## Commands

### Creating a site
```bash
$ php commander create-site
```

### Creating a user
```bash
$ php commander create-user
```

## Questions

### I have multiple nurseries, how to I manage them via the system?

You make use of the sites feature. So each nursery can either have it's own domain or sub-domain.

For example, the main nursery is called Little Devils and has the domain of little-devils-nursery.com. The business has 3 other nurseries located in various locations. Therefore we just add a sub-domain
and a site for each.

Location one, Wallsend
wallsend.little-devils-nursery.com

Location two, Battlehill
battlehill.little-devils-nursery.com

Location three, North Shields
north-shields.little-devils-nursery.com

Staff can then be attached to each site.

## Improvements

### API calls

The system currently makes a number of API calls. Should user's find the page loading to be extremely slow and the calls are the issue, we could consolidate the calls into one.

### Database queries

Improve on the database queries so that they make a single call rather than multiples to build up the result set.

### Account security

Log the number of login attempts. After say three or so, lock the account.

### Security

Make sure of the groups and hide sensitve data from certain types of users.

### Deleting

Have a warning before actually deleting which requires the user to agree before marking the item as deleted.

### Room management

Add support to manage the rooms, funding, costs, etc.