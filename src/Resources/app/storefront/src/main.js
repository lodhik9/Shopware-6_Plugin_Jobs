// Import all necessary Storefront plugins
import SwagJobExampleSecond from './SwagJobExampleSecond/SwagJobExampleSecond.plugin';

// Register your plugin via the existing PluginManager
const PluginManager = window.PluginManager;
PluginManager.register('SwagJobExampleSecond', SwagJobExampleSecond);