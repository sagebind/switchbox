<?php
namespace Switchbox\Providers;

use BadMethodCallException;

/**
 * Exception thrown when an operation is not supported by a settings provider.
 */
class NotImplementedException extends BadMethodCallException
{}
