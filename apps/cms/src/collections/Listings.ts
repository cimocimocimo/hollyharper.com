import { CollectionConfig } from 'payload/types';

const Listings: CollectionConfig = {
  slug: 'listings',
  auth: true,
  admin: {
    useAsTitle: 'email'
  },
  fields: [],
  hooks: undefined
};

export default Listings;
